<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use BalajiDharma\LaravelMenu\Models\Menu;
use BalajiDharma\LaravelAdminCore\Requests\StoreMenuRequest;
use BalajiDharma\LaravelAdminCore\Requests\UpdateMenuRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:menu list', ['only' => ['index']]);
        $this->middleware('can:menu create', ['only' => ['create', 'store']]);
        $this->middleware('can:menu edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:menu delete', ['only' => ['destroy', 'destroyMany']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $menus = (new Menu)->newQuery();

        if (request()->has('search')) {
            $menus->where('name', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $menus->orderBy('id', $attribute);
        } else {
            $menus->orderBy('id', 'desc')->latest();
        }

        if (request()->query('per_page')) {
            $menus = $menus->paginate(request()->query('per_page'))->onEachSide(2)->appends(request()->query());
        } else {
            $menus = $menus->paginate(20)->onEachSide(2)->appends(request()->query());
        }

        return Inertia::render('Admin/Menu/Index', [
            'menus' => $menus,
            'filters' => request()->all('search'),
            'can' => [
                'create' => Auth::user()->can('menu create'),
                'edit' => Auth::user()->can('menu edit'),
                'delete' => Auth::user()->can('menu delete'),
                'manage' => Auth::user()->can('menu.item index'),
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
        return Inertia::render('Admin/Menu/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMenuRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMenuRequest $request)
    {
        $menu = Menu::create([
            'name' => $request->name,
            'machine_name' => $request->machine_name,
            'description' => $request->description,
        ]);

        activity()->performedOn($menu)->withProperties(['ip' => $request->ip(), 'model' => 'Menu'])->log('create');

        return redirect()->route('menu.index')
            ->with('message', 'Menu created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \BalajiDharma\LaravelMenu\Models\Menu  $menu
     * @return \Inertia\Response
     */
    public function edit(Menu $menu)
    {
        return Inertia::render('Admin/Menu/Edit', [
            'menu' => $menu,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMenuRequest  $request
     * @param  \BalajiDharma\LaravelMenu\Models\Menu  $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->all());

        activity()->performedOn($menu)->withProperties(['ip' => $request->ip(), 'model' => 'Menu'])->log('update');

        return redirect()->route('menu.edit', $menu->id)
            ->with('message', 'Menu updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \BalajiDharma\LaravelMenu\Models\Menu  $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Menu $menu)
    {
        activity()->performedOn($menu)->withProperties(['ip' => $request->ip(), 'model' => 'Menu'])->log('delete');
        $menu->delete();

        return redirect()->route('menu.index')
            ->with('message', __('Menu deleted successfully'));
    }

    public function destroyMany(Request $request)
    {
        //Log::info(json_encode($request->bulk)); 
        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $menu = Menu::find($id);
                activity()->performedOn($menu)->withProperties(['ip' => $request->ip(), 'model' => 'Menu'])->log('delete');
            }
        } else if ($request->id) {
            $menu = Menu::find($request->id);
            activity()->performedOn($menu)->withProperties(['ip' => $request->ip(), 'model' => 'Menu'])->log('delete');
        }
        Menu::destroy($request->id);
        if ($request->bulk) {
            $message = 'Bulk update was successful.';
        } else {
            $message = 'Menu deleted successfully.';
        }

        return redirect()->route('menu.index')
            ->with('message', __($message));
    }
}
