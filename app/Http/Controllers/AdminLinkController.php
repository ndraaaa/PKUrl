<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class AdminLinkController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = Link::query()
            ->when($request->search, function ($q) use ($request) {
                $search = $request->search;

                $q->where(function ($qq) use ($search) {

                    // 🔗 field di tabel links
                    $qq->where('title', 'like', "%{$search}%")
                        ->orWhere('original_url', 'like', "%{$search}%")
                        ->orWhere('short_code', 'like', "%{$search}%");

                    $qq->orWhereHas('page', function ($page) use ($search) {
                        $page->where('title', 'like', "%{$search}%");
                    });

                    $qq->orWhereHas('page.user', function ($user) use ($search) {
                        $user->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
                    });

                    $qq->orWhereHas('user', function ($user) use ($search) {
                        $user->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
                    });
                });
            })
            ->latest();

        // 🌿 BIO LINKS → user dari page
        $bioLinks = (clone $baseQuery)
            ->whereNotNull('page_id')
            ->with(['page.user'])
            ->paginate(15, ['*'], 'bio_page');

        // ⚡ SHORTLINK → user langsung
        $shortLinks = (clone $baseQuery)
            ->whereNull('page_id')
            ->with('user')
            ->paginate(15, ['*'], 'short_page');

        return view('admin.links.index', compact('bioLinks', 'shortLinks'));
    }

    public function toggle(Link $link)
    {
        $link->update(['is_active' => ! $link->is_active]);
        return back()->with('success', 'Status link diperbarui.');
    }

    public function destroy(Link $link)
    {
        $link->delete();
        return back()->with('success', 'Link berhasil dihapus.');
    }
}
