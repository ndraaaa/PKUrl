<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PageController extends Controller
{
    // 1. INDEX: Tampilkan daftar halaman (Dashboard)
    public function index()
    {
        $pages = Auth::user()->pages()->latest()->get();
        return view('pages.index', compact('pages'));
    }

    // 2. STORE: Buat Halaman Baru
    public function store(Request $request)
    {
        $request->validate([
            'handle' => [
                'required',
                'alpha_dash',
                'unique:pages,handle',
                'unique:links,short_code',
                'not_in:login,register,logout,password,dashboard,pages,links,shortlinks,profile,admin,guest'
            ],
            'title'  => 'required|max:50',
        ], [
            'handle.required'   => 'Link Handle wajib diisi.',
            'handle.alpha_dash' => 'Link Handle hanya boleh berisi huruf, angka, strip (-), dan garis bawah (_).',
            'handle.unique'     => 'Link Handle ini sudah digunakan, silakan pilih yang lain.',
            'handle.not_in'     => 'Kata ini adalah tautan sistem dan tidak boleh digunakan.',
            'title.required'    => 'Nama halaman wajib diisi.',
            'title.max'         => 'Nama halaman maksimal 50 karakter.',
        ]);

        Auth::user()->pages()->create([
            'handle' => Str::lower($request->handle),
            'title'  => $request->title,
            'appearance' => [
                'theme' => 'default',
                'background_type' => 'color',
                'background_value' => '#ffffff',
                'text_color' => '#000000',
                'button_shape' => 'rounded'
            ]
        ]);

        return redirect()->back()->with('success', 'Halaman baru berhasil dibuat!');
    }

    // 3. EDIT: Masuk ke Editor
    public function edit(Page $page)
    {
        if ($page->user_id !== Auth::id()) abort(403);
        $links = $page->links()->orderBy('order', 'asc')->get();
        return view('pages.edit', compact('page', 'links'));
    }

    public function update(Request $request, Page $page)
    {
        if ($page->user_id !== Auth::id()) abort(403);

        if ($request->has('toggle_only')) {
            $page->update([
                'is_public' => $request->boolean('is_public')
            ]);
            return response()->json(['status' => 'success']);
        }

        $request->validate([
            'handle' => [
                'required',
                'alpha_dash',
                Rule::unique('pages')->ignore($page->id),
                'unique:links,short_code',
                'not_in:login,register,logout,password,dashboard,pages,links,shortlinks,profile,admin,guest'
            ],
            'title'  => 'required|max:50',
            'bio'    => 'nullable|max:500',
            'avatar' => 'nullable|image|max:5120',
            'background_image' => 'nullable|image|max:5120',
        ], [
            'handle.required'   => 'Link Handle wajib diisi.',
            'handle.alpha_dash' => 'Link Handle hanya boleh berisi huruf, angka, strip (-), dan garis bawah (_).',
            'handle.unique'     => 'Link Handle ini sudah digunakan, silakan pilih yang lain.',
            'handle.not_in'     => 'Kata ini adalah tautan sistem dan tidak boleh digunakan.',
            'title.required'    => 'Nama halaman wajib diisi.',
            'title.max'         => 'Nama halaman maksimal 50 karakter.',
            'bio.max'           => 'Bio maksimal 500 karakter.',
            'avatar.image'      => 'File avatar harus berupa gambar.',
            'avatar.max'        => 'Ukuran maksimal avatar adalah 5MB.',
            'background_image.image' => 'File background harus berupa gambar.',
            'background_image.max'   => 'Ukuran maksimal background adalah 5MB.',
        ]);

        // Hapus Avatar Lama jika diminta
        if ($request->has('delete_avatar')) {
            if ($page->avatar_path && Storage::disk('public')->exists($page->avatar_path)) {
                Storage::disk('public')->delete($page->avatar_path);
            }
            $page->avatar_path = null;
        }

        // Upload Avatar Baru
        if ($request->hasFile('avatar')) {
            if ($page->avatar_path && Storage::disk('public')->exists($page->avatar_path)) {
                Storage::disk('public')->delete($page->avatar_path);
            }
            $page->avatar_path = $request->file('avatar')->store('avatars', 'public');
        }

        $page->handle = Str::lower($request->handle);
        $page->title  = $request->title;
        $page->bio    = $request->bio;

        $currentAppearance = $page->appearance ?? [];

        if ($request->has('theme')) {
            $currentAppearance['theme'] = $request->theme;

            // Jika memilih tema kustom, simpan kode warnanya (hex)
            if ($request->theme === 'custom') {
                $currentAppearance['background_type'] = 'color';
                $currentAppearance['background_value'] = $request->background_value ?? '#10b981';
            }
        }

        if ($request->hasFile('background_image')) {
            if (isset($currentAppearance['background_image_path']) && Storage::disk('public')->exists($currentAppearance['background_image_path'])) {
                Storage::disk('public')->delete($currentAppearance['background_image_path']);
            }

            $bgPath = $request->file('background_image')->store('backgrounds', 'public');
            $currentAppearance['background_type'] = 'image';
            $currentAppearance['background_image_path'] = $bgPath;
        }

        if ($request->has('delete_background')) {
            if (isset($currentAppearance['background_image_path']) && Storage::disk('public')->exists($currentAppearance['background_image_path'])) {
                Storage::disk('public')->delete($currentAppearance['background_image_path']);
            }

            $currentAppearance['background_type'] = 'color';
            $currentAppearance['background_image_path'] = null;
        }

        $page->appearance = $currentAppearance;
        $page->save();

        return back()->with('success', 'Tampilan diperbarui!')->with('tab', 'appearance');
    }

    // 5. DELETE PAGE
    public function destroy(Page $page)
    {
        if ($page->user_id !== Auth::id()) abort(403);

        if ($page->avatar_path && Storage::disk('public')->exists($page->avatar_path)) {
            Storage::disk('public')->delete($page->avatar_path);
        }

        if (isset($page->appearance['background_image_path'])) {
            $path = $page->appearance['background_image_path'];
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $page->delete();

        return redirect()->route('pages.index')->with('success', 'Halaman dihapus.');
    }
}
