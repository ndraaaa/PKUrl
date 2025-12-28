<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // 1. EDIT: Tampilkan Form
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
            'name' => ['required', 'string', 'max:255'],
            // Email harus unik, tapi abaikan email milik user ini sendiri
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:admin,user'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Jika password diisi, baru kita ubah. Jika kosong, biarkan password lama.
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['min:8', 'confirmed'],
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Data user berhasil diperbarui.');
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
