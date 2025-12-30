<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        // 1. Validasi (Sama seperti sebelumnya)
        $request->validate([
            'original_url' => 'required|url',
            'custom_code'  => 'nullable|alpha_dash|unique:links,short_code|max:20|not_in:login,register,dashboard,admin,bio,logout',
        ]);

        // 2. Tentukan Short Code
        if ($request->filled('custom_code')) {
            $shortCode = $request->custom_code;
        } else {
            do {
                $shortCode = Str::random(6);
            } while (Link::where('short_code', $shortCode)->exists());
        }

        // 3. Simpan Data Link ke Database Dulu (Agar punya ID)
        $link = Auth::user()->links()->create([
            'original_url' => $request->original_url,
            'short_code'   => $shortCode,
            'type'         => 'shortlink',
            'title'        => 'Short Link',
        ]);

        // --- PROSES GENERATE & SIMPAN QR CODE ---

        // A. Tentukan Path Penyimpanan
        $fileName = 'qr_' . $link->id . '_' . $shortCode . '.svg';
        $path = 'qrcodes/' . $fileName;

        // B. Generate QR Code SVG MURNI (String Text)
        // Kita tidak pakai ->merge() bawaan library karena sering gagal di SVG
        $qrContent = QrCode::format('svg')
            ->size(300)
            ->errorCorrection('H') // Wajib H agar QR tetap terbaca meski tengahnya ditutup
            ->margin(1)
            ->generate(url($shortCode));

        // C. Proses "Bedah & Sisip" Logo Manual
        if (Auth::user()->profile && file_exists(public_path('storage/' . Auth::user()->profile))) {

            // 1. Ambil file gambar profil & Ubah jadi Base64 String
            $profilePath = public_path('storage/' . Auth::user()->profile);
            $profileData = file_get_contents($profilePath);
            $fileType   = pathinfo($profilePath, PATHINFO_EXTENSION);
            $base64Logo = 'data:image/' . $fileType . ';base64,' . base64_encode($profileData);

            // 2. Buat Tag SVG untuk Logo
            // Kita buat background putih dulu (rect) biar QR di belakangnya tertutup bersih
            // Lalu tumpuk dengan gambar (image)
            // Posisi x=35% y=35% width=30% height=30% (Pas di tengah)
            $logoTag = '
                <rect x="35%" y="35%" width="30%" height="30%" fill="#ffffff" />
                <image x="35%" y="35%" width="30%" height="30%" href="' . $base64Logo . '" />
            ';

            // 3. Sisipkan tag logo tadi SEBELUM penutup </svg>
            $qrContent = str_replace('</svg>', $logoTag . '</svg>', $qrContent);
        }

        // D. Simpan File SVG Final ke Storage
        Storage::disk('public')->put($path, $qrContent);

        // E. Update Database
        $link->update(['qr_path' => $path]);

        // ----------------------------------------

        return redirect()->back()->with('success', 'Link berhasil dibuat dan QR Code tersimpan!');
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
    public function resolvePath($path)
    {
        // 1. CEK APAKAH INI SHORTLINK?
        $link = Link::where('short_code', $path)->first();

        if ($link) {
            // Jika ketemu link pendek -> Redirect ke URL asli
            $link->increment('click_count');
            return redirect()->away($link->original_url);
        }

        // 2. JIKA BUKAN LINK, CEK APAKAH INI USERNAME (BIO)?
        $user = User::where('username', $path)->first();

        if ($user) {
            // Jika ketemu user -> Tampilkan Halaman Bio
            // Ambil link-link bio milik user tersebut
            $links = $user->links()
                ->where('type', 'biolink')
                ->where('is_active', true)
                ->latest()
                ->get();

            // Return view bio public (sama seperti di BioController sebelumnya)
            return view('bio.public', compact('user', 'links'));
        }

        // 3. JIKA TIDAK KETEMU KEDUANYA -> 404
        abort(404);
    }
}