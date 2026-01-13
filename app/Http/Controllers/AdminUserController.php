<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // 1. EDIT: Tampilkan Form
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username',
            'password' => 'required|min:3|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->username . '@local.app', // 🔥 FIX UTAMA
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()
            ->route('admin.users')
            ->with('success', 'User baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // 2. UPDATE: Simpan Perubahan
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username,' . $user->id,
            'role' => 'required|in:user,admin',
            'password' => 'nullable|min:3|confirmed',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;

        // 🔐 Password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 🖼️ Upload Foto Profil
        if ($request->hasFile('profile')) {

            // Hapus foto lama
            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
            }

            $path = $request->file('profile')->store('profiles', 'public');
            $user->profile = $path;
        }

        $user->save();

        return redirect()
            ->route('admin.users.edit', $user->id)
            ->with('success', 'Profil user berhasil diperbarui.');
    }

    // 3. DESTROY: Hapus User
    public function destroy($id)
    {
        // Proteksi: Jangan biarkan Admin menghapus akunnya sendiri yang sedang login
        if ($id == Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
