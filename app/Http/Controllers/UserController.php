<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
                'role' => 'required|in:super_admin,admin_desa,operator,rt_rw,viewer',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'phone' => $request->phone,
                'address' => $request->address,
                'is_active' => true,
            ]);

            Log::info('User created', ['user_id' => $user->id, 'by' => auth()->id()]);
            return redirect()->route('users.index')->with('status', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Failed to create user', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menambahkan user. Silakan coba lagi.');
        }
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            // Prevent non-super_admin from editing super_admin
            if ($user->role === 'super_admin' && auth()->user()->role !== 'super_admin') {
                abort(403, 'Tidak dapat mengubah data Super Admin.');
            }

            // Prevent changing own role
            if ($user->id === auth()->id() && $request->role !== $user->role) {
                return redirect()->back()->with('error', 'Tidak dapat mengubah role sendiri!');
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
                'password' => 'nullable|min:8|confirmed',
                'role' => 'required|in:super_admin,admin_desa,operator,rt_rw,viewer',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'is_active' => 'boolean',
            ]);

            $data = $request->only(['name', 'email', 'role', 'phone', 'address']);
            $data['is_active'] = $request->boolean('is_active');
            
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            Log::info('User updated', ['user_id' => $user->id, 'by' => auth()->id()]);
            return redirect()->route('users.index')->with('status', 'User berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update user', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal memperbarui user. Silakan coba lagi.');
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->id === auth()->id()) {
                return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun sendiri!');
            }

            // Prevent deleting super_admin
            if ($user->role === 'super_admin') {
                return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus Super Admin!');
            }

            // Only super_admin can delete users
            if (auth()->user()->role !== 'super_admin') {
                abort(403, 'Hanya Super Admin yang dapat menghapus user.');
            }

            Log::info('User deleted', ['user_id' => $user->id, 'by' => auth()->id()]);
            $user->delete();
            return redirect()->route('users.index')->with('status', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Failed to delete user', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menghapus user. Silakan coba lagi.');
        }
    }

    public function toggleStatus(User $user)
    {
        // Prevent toggling super_admin status
        if ($user->role === 'super_admin') {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menonaktifkan Super Admin!');
        }

        // Prevent toggling own status
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat mengubah status akun sendiri!');
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('users.index')->with('status', "User berhasil {$status}!");
    }
}