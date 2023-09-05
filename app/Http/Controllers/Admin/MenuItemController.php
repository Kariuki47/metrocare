<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use BalajiDharma\LaravelAdminCore\Requests\StoreMenuItemRequest;
use BalajiDharma\LaravelAdminCore\Requests\UpdateMenuItemRequest;
use BalajiDharma\LaravelMenu\Models\Menu;
use BalajiDharma\LaravelMenu\Models\MenuItem;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:menu.item list', ['only' => ['index']]);
        $this->middleware('can:menu.item create', ['only' => ['create', 'store']]);
        $this->middleware('can:menu.item edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:menu.item delete', ['only' => ['destroy', 'destroyMany']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Menu $menu)
    {
        $items = (new MenuItem)->newQuery();
        $items->where('menu_id', $menu->id);

        if (request()->has('search')) {
            $items->where('name', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $items->orderBy('id', $attribute);
        } else {
            $items->orderBy('id', 'desc')->latest();
        }

        if (request()->query('per_page')) {
            $items = $items->paginate(request()->query('per_page'))->onEachSide(2)->appends(request()->query());
        }else{
            $items = $items->paginate(20)->onEachSide(2)->appends(request()->query());
        }

        return Inertia::render('Admin/Menu/Item/Index', [
            'menu' => $menu,
            'items' => $items,
            'can' => [
                'create' => Auth::user()->can('menu.item create'),
                'edit' => Auth::user()->can('menu.item edit'),
                'delete' => Auth::user()->can('menu.item delete'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(Menu $menu)
    {
        $item_options = MenuItem::selectOptions($menu->id);
        return Inertia::render('Admin/Menu/Item/Create', [
            'menu' => $menu,
            'item_options' => $item_options
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMenuItemRequest  $request
     * @param  \BalajiDharma\LaravelMenu\Models\Menu $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMenuItemRequest $request, Menu $menu)
    {
        $menuItem = $menu->menuItems()->create($request->all());
        activity()->performedOn($menuItem)->withProperties(['ip' => $request->ip(), 'model' => 'Menu Item'])->log('create');

        return redirect()->route('menu.item.index', $menu->id)
                        ->with('message', 'Menu created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \BalajiDharma\LaravelMenu\Models\Menu $menu
     * @return \Inertia\Response
     */
    public function edit(Menu $menu, MenuItem $item)
    {
        $item_options = MenuItem::selectOptions($menu->id, $item->parent_id ?? $item->id);
        return Inertia::render('Admin/Menu/Item/Edit', [
            'menu' => $menu,
            'item' => $item,
            'item_options' => $item_options
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMenuItemRequest  $request
     * @param  \BalajiDharma\LaravelMenu\Models\Menu $menu
     * @param  \BalajiDharma\LaravelMenu\Models\MenuItem $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateMenuItemRequest $request, Menu $menu, MenuItem $item)
    {
        $item->update($request->all());
        activity()->performedOn($item)->withProperties(['ip' => $request->ip(), 'model' => 'Menu Item'])->log('update');

        return redirect()->route('menu.item.index', $menu->id)
                        ->with('message', 'Menu Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \BalajiDharma\LaravelMenu\Models\Menu $menu
     * @param  \BalajiDharma\LaravelMenu\Models\MenuItem $menuItem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Menu $menu, MenuItem $item)
    {
        activity()->performedOn($item)->withProperties(['ip' => $request->ip(), 'model' => 'Menu Item'])->log('delete');
        $item->delete();

        return redirect()->route('menu.item.index', $menu->id)
                        ->with('message', __('Menu deleted successfully'));
    }
    
    public function destroyMany(Request $request)
    {
        //Log::info($request->id);
        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $menus = MenuItem::find($id);
                activity()->performedOn($menus)->withProperties(['ip' => $request->ip(), 'model' => 'Menu Item'])->log('delete');
            }
        } else if ($request->id) {
            $menus = MenuItem::find($request->id);
            activity()->performedOn($menus)->withProperties(['ip' => $request->ip(), 'model' => 'Menu Item'])->log('delete');
        }
        if($request->bulk){
            $menuitem = MenuItem::whereIn('id', $request->id)->first();
            $message = 'Bulk update was successful.';
        }else{
            $menuitem = MenuItem::find($request->id);
            $message = 'Menu item deleted successfully.';
        }
        $menu = Menu::find($menuitem->menu_id);
        MenuItem::destroy($request->id);

        return redirect()->route('menu.item.index', $menu->id)
            ->with('message', __($message));
    }
}