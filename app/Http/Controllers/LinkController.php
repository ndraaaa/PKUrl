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
        // Ambil link milik user yang login, khusus tipe 'shortlink'
        // Urutkan dari yang terbaru
        $links = Auth::user()->links()
            ->where('type', 'shortlink')
            ->latest()
            ->get();

        return view('links.index', compact('links'));
    }

    // Proses memendekkan link
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'original_url' => 'required|url',
            'custom_code'  => [
                'nullable',
                'alpha_dash',
                'unique:links,short_code',
                'max:20',
                // Daftar kata terlarang (Blacklist)
                'not_in:login,register,dashboard,admin,bio,logout,password'
            ],
        ]);

        // 2. Tentukan Short Code
        if ($request->filled('custom_code')) {
            // Jika user mengisi custom code, pakai itu
            $shortCode = $request->custom_code;
        } else {
            // Jika kosong, generate random seperti sebelumnya
            do {
                $shortCode = Str::random(6);
            } while (Link::where('short_code', $shortCode)->exists());
        }

        // 3. Simpan ke Database
        Auth::user()->links()->create([
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
        $link = Auth::user()->links()->findOrFail($id);
        $link->delete();

        return redirect()->back()->with('success', 'Link berhasil dihapus.');
    }

    // FUNGSI BARU: Menangani Redirect Link Pendek
    public function redirect($code)
    {
        // 1. Cari link berdasarkan short_code
        // first() artinya ambil satu data pertama yang cocok
        $link = Link::where('short_code', $code)->first();

        // 2. Jika link tidak ditemukan, tampilkan 404 Not Found
        if (!$link) {
            abort(404);
        }

        // 3. Tambah statistik klik (+1)
        $link->increment('click_count');

        // 4. Redirect ke URL asli
        return redirect()->away($link->original_url);
    }
}
