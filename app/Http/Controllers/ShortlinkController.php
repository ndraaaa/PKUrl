<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShortlinkController extends Controller
{
    // 1. TAMPILKAN DAFTAR LINK
    public function index(Request $request)
    {
        $query = Link::where('user_id', Auth::id())
            ->whereNull('page_id');

        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('original_url', 'like', "%{$search}%")
                    ->orWhere('short_code', 'like', "%{$search}%");
            });
        }

        // Sortir
        $sortColumn = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortColumn, $sortDirection);

        $links = $query->paginate(50)->withQueryString();

        // [BARU] Logika Real-time
        // Jika request datang dari Javascript (AJAX), kembalikan potongan tabel saja
        if ($request->ajax()) {
            return view('shortlinks.partials.list', compact('links'))->render();
        }

        // Jika request biasa, kembalikan full halaman
        return view('shortlinks.index', compact('links'));
    }

    // 2. SIMPAN & GENERATE QR
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
            'custom_code'  => 'nullable|alpha_dash|unique:links,short_code|max:20',
        ]);

        // Buat slug
        if ($request->filled('custom_code')) {
            $shortCode = $request->custom_code;
        } else {
            do {
                $shortCode = Str::random(6);
            } while (Link::where('short_code', $shortCode)->exists());
        }

        // Simpan Data
        $link = Link::create([
            'user_id'      => Auth::id(),
            'page_id'      => null, // PENTING: Null artinya Global
            'original_url' => $request->original_url,
            'short_code'   => $shortCode,
            'title'        => 'Shortlink',
            'type'         => 'shortlink',
            'is_active'    => true,
        ]);

        // --- GENERATE QR CODE ---
        $this->generateQr($link);

        return redirect()->back()->with('success', 'Shortlink berhasil dibuat!');
    }

    // 3. HAPUS LINK
    public function destroy(Link $link) // Ubah dari Shortlink ke Link
    {
        $link->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Link dihapus');
    }

    // 4. ON/OFF LINK (TOGGLE)
    public function toggle(Link $link) // Ubah dari Shortlink ke Link
    {
        $link->update(['is_active' => !$link->is_active]);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Status diperbarui');
    }

    // HELPER: Generate QR Logic
    private function generateQr($link)
    {
        // 1. Pastikan folder penyimpanan ada
        if (!Storage::disk('public')->exists('qrcodes')) {
            Storage::disk('public')->makeDirectory('qrcodes');
        }

        $fileName = 'qr_' . $link->short_code . '.svg';
        $path = 'qrcodes/' . $fileName;

        // 2. Generate QR Code Dasar (SVG)
        $qrContent = QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->errorCorrection('H') // Error Correction tinggi agar logo tidak merusak QR
            ->generate(url($link->short_code));

        // 3. Tentukan Lokasi Logo Aplikasi
        $logoPath = public_path('images/logo.png');

        // 4. Proses Penyisipan Logo
        if (file_exists($logoPath)) {

            // Konversi Gambar ke Base64
            $logoData = file_get_contents($logoPath);
            $fileType = pathinfo($logoPath, PATHINFO_EXTENSION);

            // Fix minor untuk ekstensi jpg
            if ($fileType == 'jpg') $fileType = 'jpeg';

            $base64Logo = 'data:image/' . $fileType . ';base64,' . base64_encode($logoData);

            // Buat Tag XML untuk Logo
            // <rect>: Membuat kotak putih di belakang logo agar QR code tidak menabrak logo
            // <image>: Menampilkan logo itu sendiri
            $logoTag = '
                <rect x="35%" y="35%" width="30%" height="30%" fill="#ffffff" rx="15" ry="15" />
                <image x="35%" y="35%" width="30%" height="30%" preserveAspectRatio="xMidYMid slice" href="' . $base64Logo . '" />
            ';

            // Sisipkan Logo ke tengah QR Code
            $qrContent = str_replace('</svg>', $logoTag . '</svg>', $qrContent);
        }

        // 5. Simpan File
        Storage::disk('public')->put($path, $qrContent);

        // 6. Update Database
        $link->update(['qr_path' => $path]);
    }
}