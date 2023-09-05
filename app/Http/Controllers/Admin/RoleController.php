<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use BalajiDharma\LaravelAdminCore\Requests\StoreRoleRequest;
use BalajiDharma\LaravelAdminCore\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:role list', ['only' => ['index']]);
        $this->middleware('can:role create', ['only' => ['create', 'store']]);
        $this->middleware('can:role edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:role delete', ['only' => ['destroy', 'destroyMany']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $roles = (new Role)->newQuery();

        if (request()->has('search')) {
            $roles->where('name', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $roles->orderBy('id', $attribute);
        } else {
            $roles->orderBy('id', 'desc')->latest();
        }

        if (request()->query('per_page')) {
            $roles = $roles->paginate(request()->query('per_page'))->onEachSide(2)->appends(request()->query());
        }else{
            $roles = $roles->paginate(20)->onEachSide(2)->appends(request()->query());
        }

        return Inertia::render('Admin/Role/Index', [
            'roles' => $roles,
            'filters' => request()->all('search'),
            'can' => [
                'create' => Auth::user()->can('role create'),
                'edit' => Auth::user()->can('role edit'),
                'delete' => Auth::user()->can('role delete'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $permissions = Permission::all()->pluck("name","id");

        return Inertia::render('Admin/Role/Create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRoleRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        activity()->performedOn($role)->withProperties(['ip' => $request->ip(), 'model' => 'Role'])->log('create');

        if (! empty($request->permissions)) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('role.index')
                        ->with('message', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Inertia\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all()->pluck("name","id");
        $roleHasPermissions = array_column(json_decode($role->permissions, true), 'id');

        return Inertia::render('Admin/Role/Edit', [
            'role' => $role,
            'permissions' => $permissions,
            'roleHasPermissions' => $roleHasPermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $permissions = $request->permissions ?? [];
        $role->syncPermissions($permissions);
        activity()->performedOn($role)->withProperties(['ip' => $request->ip(), 'model' => 'Role'])->log('update');

        return redirect()->route('role.edit', $role->id)
                        ->with('message', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Role $role)
    {
        activity()->performedOn($role)->withProperties(['ip' => $request->ip(), 'model' => 'Role'])->log('delete');
        $role->delete();

        return redirect()->route('role.index')
                        ->with('message', __('Role deleted successfully'));
    }

    public function destroyMany(Request $request)
    {
        //Log::info(json_encode($request->id)); 
        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $role = Role::find($id);
                activity()->performedOn($role)->withProperties(['ip' => $request->ip(), 'model' => 'Role'])->log('delete');
            }
        } else if ($request->id) {
            $role = Role::find($request->id);
            activity()->performedOn($role)->withProperties(['ip' => $request->ip(), 'model' => 'Role'])->log('delete');
        }
        Role::destroy($request->id);
        if($request->bulk){
            $message = 'Bulk update was successful';
        }else{
            $message = 'Role has been deleted successfully';
        }

        return redirect()->route('role.index')
            ->with('message', __($message));
    }
}
