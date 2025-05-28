<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = Schema::getColumnListing('users');

        $user = QueryBuilder::for(User::class)
            ->allowedFilters($columns)
            ->allowedSorts($columns)
            ->paginate()
            ->appends($request->query());

        return view('user.index', [
            'user' => UserResource::collection($user),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        // gán role cho người dùng
        $user = User::create($data);
        $user->assignRole($data['role']);

        return redirect()->route('admin.users.index')->with('success', 'người dùng được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', [
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        $user->syncRoles($data['role']);
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.users.index')->with('error', 'Không thể xóa tài khoản admin.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa thành công.');
    }
}
