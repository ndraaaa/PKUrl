<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    // Menampilkan daftar halaman milik user
    public function index()
    {
        $pages = Auth::user()->pages()->latest()->get();
        return view('pages.index', compact('pages'));
    }

    // Menyimpan halaman baru
    public function store(Request $request)
    {
        $request->validate([
            'handle' => ['required', 'alpha_dash', 'unique:pages,handle', 'not_in:login,register,dashboard'],
            'title' => 'required|max:50',
        ]);

        Auth::user()->pages()->create([
            'handle' => $request->handle,
            'title' => $request->title,
            'theme' => 'default'
        ]);

        return redirect()->back()->with('success', 'Halaman baru berhasil dibuat!');
    }

    // Masuk ke Dashboard Editor untuk Page tertentu
    public function edit(Page $page)
    {
        if ($page->user_id !== Auth::id()) {
            abort(403);
        }

        // AMBIL LINKS JUGA (Agar bisa dikelola di satu halaman)
        $links = $page->links()
            ->orderBy('order')
            ->get();

        return view('pages.edit', compact('page', 'links'));
    }

    public function update(Request $request, Page $page)
    {
        // Security: Pastikan page milik user
        if ($page->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'handle' => ['required', 'alpha_dash', 'unique:pages,handle,' . $page->id],
            'title'  => 'required|max:50',
            'theme'  => 'required',
            'avatar' => 'nullable|image|max:2048',
            'background_image' => 'nullable|image|max:3072',
        ]);

        $data = [
            'handle' => $request->handle,
            'title'  => $request->title,
            'theme'  => $request->theme,
        ];

        // Handle File Upload Avatar
        if ($request->hasFile('avatar')) {
            if ($page->avatar) {
                Storage::disk('public')->delete($page->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Handle File Upload Background Image
        if ($request->hasFile('background_image')) {
            if ($page->background_image) {
                Storage::disk('public')->delete($page->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('backgrounds', 'public');
        }

        // Handle Hapus Background
        if ($request->has('remove_background')) {
            if ($page->background_image) {
                Storage::disk('public')->delete($page->background_image);
            }
            $data['background_image'] = null;
        }

        $page->update($data);

        // --- UPDATE PENTING UNTUK AJAX ---
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Perubahan berhasil disimpan!',
                'new_avatar' => isset($data['avatar']) ? asset('storage/' . $data['avatar']) : null
            ]);
        }

        return redirect()->back()->with('success', 'Perubahan berhasil disimpan!');
    }

    public function destroy(Page $page)
    {
        // Security Check (Opsional tapi disarankan)
        if ($page->user_id !== Auth::id()) {
            abort(403);
        }

        if ($page->avatar) {
            Storage::disk('public')->delete($page->avatar);
        }

        if ($page->background_image) {
            Storage::disk('public')->delete($page->background_image);
        }

        $page->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('dashboard')->with('success', 'Halaman berhasil dihapus');
    }
}