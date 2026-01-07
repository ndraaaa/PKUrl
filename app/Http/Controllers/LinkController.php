<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LinkController extends Controller
{
    // 1. TAMPILKAN LINK MILIK HALAMAN TERTENTU
    public function index(Request $request, Page $page)
    {
        // Security Check: Pastikan halaman ini milik user yang login
        if ($page->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil link HANYA milik page ini
        $query = $page->links();

        // Fitur Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('original_url', 'like', "%{$search}%");
            });
        }

        // Fitur Sortir
        $sortColumn = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortColumn, $sortDirection);

        $links = $query->paginate(50)->withQueryString();

        return view('links.index', compact('links', 'page'));
    }

    // 2. SIMPAN LINK BARU KE HALAMAN
    public function store(Request $request, Page $page)
    {
        // Security Check
        if ($page->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'original_url' => 'required|url',
            'title'        => 'required|max:50', // Judul Wajib untuk Bio (mis: "Instagram Saya")
        ]);

        // Generate Shortcode (Opsional untuk link bio, tapi tetap kita buat unik)
        do {
            $shortCode = Str::random(6);
        } while (Link::where('short_code', $shortCode)->exists());

        // Simpan via relasi page
        $link = $page->links()->create([
            'original_url' => $request->original_url,
            'title'        => $request->title,
            'short_code'   => $shortCode,
            'type'         => 'biolink', // Penanda bahwa ini Link Bio
            'is_active'    => true,
            'click_count'  => 0,
        ]);

        // Generate QR (Opsional, jika ingin setiap tombol punya QR sendiri)
        $this->generateQr($link);

        return redirect()->back()->with('success', 'Tautan berhasil ditambahkan ke Bio!');
    }

    // 3. HAPUS LINK
    public function destroy($id)
    {
        // Cari link milik user (via Page)
        // Kita gunakan Auth::user()->pageLinks() atau cari manual
        $link = Link::where('id', $id)->firstOrFail();

        // Pastikan Page pemilik link ini adalah milik user yang login
        if ($link->page->user_id !== Auth::id()) {
            abort(403);
        }

        if ($link->qr_path && Storage::disk('public')->exists($link->qr_path)) {
            Storage::disk('public')->delete($link->qr_path);
        }

        $link->delete();

        return redirect()->back()->with('success', 'Tautan dihapus.');
    }

    // 4. TOGGLE STATUS
    public function toggleStatus($id)
    {
        $link = Link::where('id', $id)->firstOrFail();

        if ($link->page->user_id !== Auth::id()) {
            abort(403);
        }

        $link->update(['is_active' => !$link->is_active]);

        return redirect()->back()->with('success', 'Status tautan diperbarui.');
    }

    // 5. PUBLIC RESOLVER (Menangani domain.com/username)
    public function resolvePath($path)
    {
        // A. Cek Shortlink Global dulu (Prioritas)
        $link = Link::where('short_code', $path)->whereNull('page_id')->first();
        if ($link && $link->is_active) {
            $link->increment('click_count');
            return redirect()->away($link->original_url);
        }

        // B. Cek Halaman Bio (Page Handle)
        $page = Page::where('handle', $path)->first();
        if ($page) {
            $user  = $page->user;
            // Ambil link bio yang aktif
            $links = $page->links()->where('is_active', true)->orderBy('created_at', 'desc')->get();

            return view('bio.public', compact('user', 'page', 'links'));
        }

        abort(404);
    }

    // HELPER QR (Sama seperti shortlink tapi optional logo)
    private function generateQr($link)
    {
        if (!Storage::disk('public')->exists('qrcodes')) {
            Storage::disk('public')->makeDirectory('qrcodes');
        }
        $path = 'qrcodes/bio_' . $link->short_code . '.svg';

        $qrContent = QrCode::format('svg')->size(300)->margin(1)->generate(url($link->short_code));
        Storage::disk('public')->put($path, $qrContent);
        $link->update(['qr_path' => $path]);
    }

    public function update(Request $request, $id)
    {
        // Cari link berdasarkan ID
        $link = Link::findOrFail($id);

        // Security Check: Pastikan Page pemilik link ini adalah milik user yang login
        if ($link->page->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'        => 'required|max:50',
            'original_url' => 'required|url',
        ]);

        $link->update([
            'title'        => $request->title,
            'original_url' => $request->original_url,
        ]);

        return redirect()->back()->with('success', 'Tautan berhasil diperbarui.');
    }
}