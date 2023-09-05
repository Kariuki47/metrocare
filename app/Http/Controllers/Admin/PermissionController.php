<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use BalajiDharma\LaravelAdminCore\Requests\StorePermissionRequest;
use BalajiDharma\LaravelAdminCore\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permission list', ['only' => ['index']]);
        $this->middleware('can:permission create', ['only' => ['create', 'store']]);
        $this->middleware('can:permission edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:permission delete', ['only' => ['destroy', 'destroyMany']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = (new Permission)->newQuery();

        if (request()->has('search')) {
            $permissions->where('name', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $permissions->orderBy('id', $attribute);
        } else {
            $permissions->orderBy('id', 'desc')->latest();
        }

        if (request()->query('per_page')) {
            $permissions = $permissions->paginate(request()->query('per_page'))->onEachSide(2)->appends(request()->query());
        }else{
            $permissions = $permissions->paginate(20)->onEachSide(2)->appends(request()->query());
        }

        return Inertia::render('Admin/Permission/Index', [
            'permissions' => $permissions,
            'filters' => request()->all('search'),
            'can' => [
                'create' => Auth::user()->can('permission create'),
                'edit' => Auth::user()->can('permission edit'),
                'delete' => Auth::user()->can('permission delete'),
            ]
        ]);
        //$permissions = Permission::latest()->paginate(5);
        //return view('admin.permission.index', compact('permissions'))
            //->with('i', (request()->input('page', 1) - 1) * 5);
        //return Inertia::render('Admin/Permission/Index', [
            //'permissions' => Permission::latest()->paginate(5)
        //]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Permission/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->all());
        activity()->performedOn($permission)->withProperties(['ip' => $request->ip(), 'model' => 'Permission'])->log('create');

        return redirect()->route('permission.index')
                        ->with('message', __('Permission created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return Inertia::render('Admin/Permission/Edit', [
            'permission' => $permission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->all());
        activity()->performedOn($permission)->withProperties(['ip' => $request->ip(), 'model' => 'Permission'])->log('update');

        return redirect()->route('permission.edit', $permission->id)
                        ->with('message', __('Permission updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Permission $permission)
    {
        activity()->performedOn($permission)->withProperties(['ip' => $request->ip(), 'model' => 'Permission'])->log('delete');
        $permission->delete();

        return redirect()->route('permission.index')
                        ->with('message', __('Permission deleted successfully'));
    }

    public function destroyMany(Request $request)
    {
        //Log::info(json_encode($request->id)); 
        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $permission = Permission::find($id);
                activity()->performedOn($permission)->withProperties(['ip' => $request->ip(), 'model' => 'Permission'])->log('delete');
            }
        } else if ($request->id) {
            $permission = Permission::find($request->id);
            activity()->performedOn($permission)->withProperties(['ip' => $request->ip(), 'model' => 'Permission'])->log('delete');
        }
        Permission::destroy($request->id);
        if($request->bulk){
            $message = 'Bulk update was successful';
        }else{
            $message = 'Permission has been deleted successfully';
        }

        return redirect()->route('permission.index')
            ->with('message', __($message));
    }
}
