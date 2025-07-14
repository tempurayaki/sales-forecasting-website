<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        // Hanya tampilkan user biasa, sembunyikan admin
        $users = User::where('role', 'user')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Pastikan tidak bisa membuat admin
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Fixed sebagai user
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat');
    }

    public function edit(User $user)
    {
        // Cegah edit admin
        if ($user->isHardcodedAdmin()) {
            abort(403, 'Cannot edit admin account');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    public function resetPassword(User $user)
    {
        // Cegah reset password admin
        if ($user->isHardcodedAdmin()) {
            abort(403, 'Cannot reset admin password');
        }

        // Generate password default atau random
        $newPassword = Str::random(8);
        
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Password user {$user->name} berhasil direset menjadi: {$newPassword}");
    }

    public function update(Request $request, User $user)
    {
        // Cegah update admin
        if ($user->isHardcodedAdmin()) {
            abort(403, 'Cannot update admin account');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        // Cegah hapus admin
        if ($user->isHardcodedAdmin()) {
            abort(403, 'Cannot delete admin account');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }
}