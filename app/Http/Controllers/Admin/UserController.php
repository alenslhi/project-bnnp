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
        $adminCount = User::where('role', 'admin')->count();
        $superAdminCount = User::where('role', 'super_admin')->count();
        return view('admin.users.index', compact('users', 'adminCount', 'superAdminCount'));
    }

    public function create()
    {
        $adminCount = User::where('role', 'admin')->count();
        $superAdminCount = User::where('role', 'super_admin')->count();
        return view('admin.users.create', compact('adminCount', 'superAdminCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => [
                'required',
                'in:admin',
            ],
        ], [
            'role.in' => 'Super Admin dibatasi permanen hanya 1 akun dan tidak dapat ditambah. Anda hanya dapat menambahkan akun dengan role Admin.',
        ]);

        if (User::where('role', 'admin')->count() >= 2) {
            return back()->withInput()->withErrors([
                'role' => 'Maksimal hanya diperbolehkan 2 akun dengan role Admin. Kuota akun Admin sudah penuh (2/2).',
            ]);
        }

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        \App\Models\ActivityLog::record('CREATE_USER', "Menambahkan user baru: {$user->name} ({$user->role})");

        return redirect()->route('admin.users.index')->with('success', 'User Admin berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        $adminCount = User::where('role', 'admin')->count();
        $superAdminCount = User::where('role', 'super_admin')->count();
        return view('admin.users.edit', compact('user', 'adminCount', 'superAdminCount'));
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
            'role' => [
                'required',
                'in:super_admin,admin',
                function ($attribute, $value, $fail) use ($user) {
                    if ($user->role === 'super_admin' && $value !== 'super_admin') {
                        $fail('Akun Super Admin utama tidak dapat diubah rolenya.');
                    }
                    if ($user->role !== 'super_admin' && $value === 'super_admin') {
                        $fail('Tidak dapat mengubah role menjadi Super Admin karena Super Admin hanya boleh 1 akun.');
                    }
                    if ($value === 'admin' && $user->role !== 'admin') {
                        $currentAdminCount = User::where('role', 'admin')->where('id', '!=', $user->id)->count();
                        if ($currentAdminCount >= 2) {
                            $fail('Maksimal hanya diperbolehkan 2 akun dengan role Admin.');
                        }
                    }
                },
            ],
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

        if ($user->role === 'super_admin') {
            return redirect()->route('admin.users.index')->with('error', 'Akun Super Admin utama tidak dapat dihapus.');
        }

        $userName = $user->name;
        $user->delete();

        \App\Models\ActivityLog::record('DELETE_USER', "Menghapus user: {$userName}");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
