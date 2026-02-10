<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLinkController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        // 1. Query Dasar (Eager Load)
        $query = Link::with(['user', 'page']);

        // 2. Filter Pencarian (Global)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_code', 'like', "%{$search}%")
                    ->orWhere('destination_url', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
                    });
            });
        }

        // 3. Logika Sorting
        $sortCol = $request->get('sort', 'created_at');
        $sortDir = $request->get('dir', 'desc');
        $allowed = ['title', 'short_code', 'click_count', 'created_at'];

        if (in_array($sortCol, $allowed)) {
            $query->orderBy($sortCol, $sortDir);
        } else {
            $query->latest();
        }

        // 4. Pisahkan Query untuk Dua Tab
        // Penting: Gunakan clone agar filter/sort di atas terbawa ke kedua variabel

        // A. Bio Links (Punya page_id)
        $bioLinks = (clone $query)->whereNotNull('page_id')
            ->paginate(15, ['*'], 'bio_page') // Nama page beda biar gak bentrok
            ->withQueryString();

        // B. Shortlinks (Tdk punya page_id)
        $shortLinks = (clone $query)->whereNull('page_id')
            ->paginate(15, ['*'], 'short_page')
            ->withQueryString();

        return view('admin.links.index', compact('bioLinks', 'shortLinks'));
    }

    public function toggleStatus(Link $link)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $link->update(['is_active' => !$link->is_active]);

        return response()->json([
            'status' => 'success',
            'is_active' => $link->is_active
        ]);
    }

    public function destroy(Link $link)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $link->delete();

        return back()->with('success', 'Link berhasil dihapus.');
    }
}
