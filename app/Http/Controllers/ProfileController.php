<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan Form Edit Profil User
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update Data User (Username, Nama, Foto)
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
            'profile' => ['nullable', 'image', 'max:5120'],
        ]);

        // Update Data Dasar
        $user->name = $request->name;

        // Logic Sinkronisasi Username & Email Palsu
        if ($user->username !== $request->username) {
            $user->username = $request->username;
            $user->email = strtolower($request->username) . '@local.app'; // Update email otomatis
            $user->email_verified_at = null; // Reset verifikasi jika pakai fitur ini
        }

        // Logic Upload Foto Profil (User Ganti Foto Sendiri)
        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('profiles', 'public');
            $user->profile = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'profile' => ['required', 'image', 'max:5120'],
        ]);

        $user = $request->user();

        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('profiles', 'public');
            $user->profile = $path;
            $user->save();
        }

        return back()->with('status', 'avatar-updated');
    }

    /**
     * Hapus Akun Sendiri
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Model User akan otomatis menghapus file foto & data link (Cascade)
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
