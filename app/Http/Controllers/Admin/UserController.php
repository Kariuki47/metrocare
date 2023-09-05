<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use BalajiDharma\LaravelAdminCore\Actions\User\CreateUser;
use BalajiDharma\LaravelAdminCore\Actions\User\UpdateUser;
use BalajiDharma\LaravelAdminCore\Requests\StoreUserRequest;
use BalajiDharma\LaravelAdminCore\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user list', ['only' => ['index']]);
        $this->middleware('can:user create', ['only' => ['create', 'store']]);
        $this->middleware('can:user edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:user delete', ['only' => ['destroy', 'destroyMany']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $roles = Role::get();
        $users = (new User)->newQuery();

        if (request()->has('search')) {
            $users->where('name', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $users->orderBy('id', $attribute);
        } else {
            $users->orderBy('id', 'desc')->latest();
        }

        if (request()->query('role')) {
            $role = Role::find(request()->query('role'));
            if($role){
                $users->role($role->name);
            }
            $users->latest();
        } else {
            $users->latest();
        }

        if (request()->query('per_page')) {
            $users = $users->paginate(request()->query('per_page'))->onEachSide(2)->appends(request()->query());
        }else {
            $users = $users->paginate(20)->onEachSide(2)->appends(request()->query());
        }

        return Inertia::render('Admin/User/Index', [
            'users' => $users,
            'filters' => request()->all('search'),
            'can' => [
                'create' => Auth::user()->can('user create'),
                'edit' => Auth::user()->can('user edit'),
                'delete' => Auth::user()->can('user delete'),
            ],
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $roles = Role::all()->pluck("name","id");

        return Inertia::render('Admin/User/Create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @param  CreateUser  $createUser
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request, CreateUser $createUser)
    {
        $user = $createUser->handle((object) $request->all());
        activity()->performedOn($user)->withProperties(['ip' => $request->ip(), 'model' => 'User'])->log('create');

        return redirect()->route('user.index')
                        ->with('message', __('User created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all()->pluck("name","id");
        $userHasRoles = array_column(json_decode($user->roles, true), 'id');

        return Inertia::render('Admin/User/Edit', [
            'user' => $user,
            'roles' => $roles,
            'userHasRoles' => $userHasRoles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @param  UpdateUser  $updateUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUser $updateUser)
    {
        $updateUser->handle((object) $request->all(), $user);
        activity()->performedOn($user)->withProperties(['ip' => $request->ip(), 'model' => 'User'])->log('update');

        return redirect()->route('user.edit', $user->id)
                        ->with('message', __('User updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, User $user)
    {
        activity()->performedOn($user)->withProperties(['ip' => $request->ip(), 'model' => 'User'])->log('delete');
        $user->delete();

        return redirect()->route('user.index')
                        ->with('message', __('User deleted successfully'));
    }

    public function destroyMany(Request $request)
    {
        //Log::info(json_encode($request->id)); 
        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $user = User::find($id);
                activity()->performedOn($user)->withProperties(['ip' => $request->ip(), 'model' => 'User'])->log('delete');
            }
        } else if ($request->id) {
            $user = User::find($request->id);
            activity()->performedOn($user)->withProperties(['ip' => $request->ip(), 'model' => 'User'])->log('delete');
        }
        User::destroy($request->id);
        if($request->bulk){
            $message = 'Bulk update was successful';
        }else{
            $message = 'User has been deleted successfully';
        }

        return redirect()->route('user.index')
            ->with('message', __($message));
    }

}
