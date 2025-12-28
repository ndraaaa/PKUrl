<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    // Menampilkan daftar link
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $links = $user->links()
            ->where('type', 'shortlink')
            ->latest()
            ->get();

        return view('links.index', compact('links'));
    }

    // Proses memendekkan link
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
            'custom_code'  => [
                'nullable',
                'alpha_dash',
                'unique:links,short_code',
                'max:20',
                'not_in:login,register,dashboard,admin,bio,logout,password'
            ],
        ]);

        if ($request->filled('custom_code')) {
            $shortCode = $request->custom_code;
        } else {
            do {
                $shortCode = Str::random(6);
            } while (Link::where('short_code', $shortCode)->exists());
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->links()->create([
            'original_url' => $request->original_url,
            'short_code'   => $shortCode,
            'type'         => 'shortlink',
            'title'        => 'Short Link',
        ]);

        return redirect()->back()->with('success', 'Link berhasil dibuat!');
    }

    // Hapus link
    public function destroy($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $link = $user->links()->findOrFail($id);
        $link->delete();

        return redirect()->back()->with('success', 'Link berhasil dihapus.');
    }

    // Redirect Link
    public function redirect($code)
    {
        $link = Link::where('short_code', $code)->first();

        if (!$link) {
            abort(404);
        }

        $link->increment('click_count');

        return redirect()->away($link->original_url);
    }
}