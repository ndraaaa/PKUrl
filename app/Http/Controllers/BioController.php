<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class BioController extends Controller
{
    // 1. ADMIN: Halaman Pengaturan Bio
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil link tipe 'biolink' milik user
        $links = $user->links()->where('type', 'biolink')->latest()->get();

        return view('bio.index', compact('user', 'links'));
    }

    // 2. ADMIN: Update Profil (Username & profile & Theme)
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'username' => ['required', 'alpha_dash', 'max:50', Rule::unique('users')->ignore($user->id)],
            'profile'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
            'theme'    => ['required', 'in:default,ocean,midnight,sunset,nature'],
        ]);

        $user->username = $request->username;
        $user->theme    = $request->theme;

        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('profiles', 'public');
            $user->profile = $path;
        }

        $user->save(); // Saat save() dipanggil, event 'updating' di Model berjalan

        return redirect()->back()->with('success', 'Profil diperbarui!');
    }

    // 3. ADMIN: Tambah Link Baru ke Bio
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'title' => 'required|max:50',
            'original_url' => 'required|url',
        ]);

        $user->links()->create([
            'title' => $request->title,
            'original_url' => $request->original_url,
            'type' => 'biolink',
            'short_code' => Str::random(8),
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Link berhasil ditambahkan!');
    }

    public function updateLink(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:50',
            'original_url' => 'required|url',
        ]);

        // Cari link milik user, pastikan tipenya biolink
        $link = Auth::user()->links()->where('type', 'biolink')->findOrFail($id);

        $link->update([
            'title' => $request->title,
            'original_url' => $request->original_url,
        ]);

        return redirect()->back()->with('success', 'Link berhasil diperbarui!');
    }

    // 4. ADMIN: Hapus Link Bio
    public function destroy($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $link = $user->links()->where('type', 'biolink')->findOrFail($id);
        $link->delete();

        return redirect()->back()->with('success', 'Link berhasil dihapus.');
    }

    // 5. PUBLIC: Halaman Depan (Domain.com/@username)
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $links = $user->links()->where('type', 'biolink')->where('is_active', true)->latest()->get();

        return view('bio.public', compact('user', 'links'));
    }
}