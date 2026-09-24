<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = [
            'super_admin' => 'Super Admin',
            'admin_rehab' => 'Admin Rehabilitasi',
            'admin_brantas' => 'Admin Pemberantasan',
            'admin_cegah' => 'Admin Pencegahan',
        ];
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin_rehab,admin_brantas,admin_cegah',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        \App\Models\ActivityLog::record('CREATE_USER', "Menambahkan user baru: {$user->name} ({$user->role})");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = [
            'super_admin' => 'Super Admin',
            'admin_rehab' => 'Admin Rehabilitasi',
            'admin_brantas' => 'Admin Pemberantasan',
            'admin_cegah' => 'Admin Pencegahan',
        ];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin_rehab,admin_brantas,admin_cegah',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        \App\Models\ActivityLog::record('UPDATE_USER', "Mengupdate data user: {$user->name}");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Tidak bisa menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        \App\Models\ActivityLog::record('DELETE_USER', "Menghapus user: {$userName}");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
