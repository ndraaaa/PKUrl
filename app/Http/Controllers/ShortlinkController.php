<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShortLinkController extends Controller
{
    public function index(Request $request)
    {
        $query = Link::where('user_id', Auth::id())->whereNull('page_id');

        // Filter Search & Date (Kode yang sudah ada)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('short_code', 'like', "%{$request->search}%")
                    ->orWhere('destination_url', 'like', "%{$request->search}%");
            });
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // --- FUNGSI SORTING BARU ---
        // Ambil parameter 'sort' dari URL, default 'created_at'
        $sortField = $request->get('sort', 'created_at');
        // Ambil arah 'dir' (direction), default 'desc'
        $sortDirection = $request->get('dir', 'desc');

        // Whitelist kolom yang boleh di-sort (Demi keamanan)
        $allowedSorts = ['title', 'clicks', 'created_at', 'short_code'];

        if (in_array($sortField, $allowedSorts)) {
            // Jika kolom valid, lakukan sorting
            // Jika sorting berdasarkan klik, ganti 'clicks' dengan nama kolom asli di DB (misal: click_count)
            $dbColumn = $sortField === 'clicks' ? 'click_count' : $sortField;

            $query->orderBy($dbColumn, $sortDirection);
        } else {
            $query->latest();
        }

        $links = $query->paginate(10);

        return view('shortlinks.index', compact('links'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination_url' => 'required|url',
            'title'           => 'nullable|string|max:100',
            'custom_code'     => 'nullable|alpha_dash|unique:links,short_code|max:20',
        ]);

        $code = $request->custom_code ?? $this->generateUniqueCode();

        Link::create([
            'user_id'         => Auth::id(),
            'page_id'         => null,
            'destination_url' => $request->destination_url,
            'short_code'      => $code,
            'title'           => $request->title ?? 'Untitled Link',
            'type'            => 'shortlink',
            'is_active'       => true,
            'click_count'     => 0
        ]);

        return back()->with('success', 'Shortlink berhasil dibuat!');
    }

    public function update(Request $request, Link $shortlink)
    {
        if ($shortlink->user_id !== Auth::id()) abort(403);

        if ($request->has('toggle_only') || ($request->has('is_active') && !$request->has('destination_url'))) {

            $shortlink->update([
                'is_active' => $request->boolean('is_active')
            ]);

            if ($request->wantsJson()) {
                return response()->json(['status' => 'success', 'data' => $shortlink]);
            }
            return back();
        }

        $request->validate([
            'title'           => 'nullable|string|max:100',
            'destination_url' => 'required|url',
            'custom_code'     => 'required|alpha_dash|max:20|unique:links,short_code,' . $shortlink->id,
        ]);

        $shortlink->update([
            'title'           => $request->title,
            'destination_url' => $request->destination_url,
            'short_code'      => $request->custom_code,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'data' => $shortlink]);
        }

        return back()->with('success', 'Link diperbarui.');
    }

    public function destroy(Link $shortlink)
    {
        if ($shortlink->user_id !== Auth::id()) abort(403);

        $shortlink->delete();
        return back()->with('success', 'Shortlink dihapus.');
    }

    public function generateQrWithLogo(Link $link)
    {
        if ($link->user_id !== auth()->id()) abort(403);

        $targetUrl = url($link->short_code);
        $qrImage = QrCode::size(300)
            ->errorCorrection('H')
            ->generate($targetUrl);

        return response($qrImage)->header('Content-type', 'image/svg+xml');
    }

    private function generateUniqueCode()
    {
        do {
            $code = Str::random(6);
        } while (Link::where('short_code', $code)->exists());
        return $code;
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:links,id'
        ]);

        \App\Models\Link::whereIn('id', $request->ids)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->delete();

        return back()->with('success', count($request->ids) . ' Link terpilih berhasil dihapus.');
    }

    // Guest Shortlink
    public function storePublic(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        $code = $this->generateUniqueCode();

        $link = Link::create([
            'user_id'         => Auth::id() ?? null,
            'destination_url' => $request->url,
            'short_code'      => $code,
            'title'           => 'Guest Link',
            'type'            => 'shortlink',
            'is_active'       => true,
            'click_count'     => 0
        ]);

        return response()->json([
            'status' => 'success',
            'short_url' => url($link->short_code),
            'original_url' => $link->destination_url,
            'qr_code' => route('guest.qr', $link->short_code),
            'qr_download' => route('guest.qr', ['shortCode' => $link->short_code, 'download' => 'true'])
        ]);
    }

    public function showPublicQr(Request $request, $shortCode)
    {
        $link = Link::where('short_code', $shortCode)->firstOrFail();
        $targetUrl = url($link->short_code);

        $qrCode = QrCode::format('svg')
            ->size(500)
            ->errorCorrection('H')
            ->margin(1)
            ->generate($targetUrl);

        return response($qrCode)->header('Content-type', 'image/svg+xml');
    }
}