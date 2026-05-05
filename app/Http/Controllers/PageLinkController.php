<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PageLinkController extends Controller
{
    // SIMPAN TOMBOL BARU KE HALAMAN BIO
    public function store(Request $request, Page $page)
    {
        if ($page->user_id !== Auth::id()) abort(403);

        $request->validate([
            'destination_url' => 'required|url',
            'title'           => 'required|max:50',
            'type'            => 'required|in:link,header,embed',
            'icon'            => 'nullable|string',
            'display_as'      => 'nullable|in:button,social',
        ]);

        $code = Str::random(8);
        $maxOrder = $page->links()->max('order') ?? 0;

        $page->links()->create([
            'user_id'         => Auth::id(),
            'destination_url' => $request->destination_url,
            'title'           => $request->title,
            'short_code'      => $code,
            'type'            => $request->type,
            'order'           => $maxOrder + 1,
            'settings'        => [
                'icon'       => $request->icon ?? null,
                'display_as' => $request->display_as ?? 'button',
                'color'      => $request->color ?? null,
                'animation'  => $request->animation ?? null
            ],
            'is_active' => true,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Link berhasil ditambahkan']);
        }

        return back()->with('success', 'Tombol berhasil ditambahkan!');
    }

    // UPDATE TOMBOL
    public function update(Request $request, Link $link)
    {
        if ($link->page->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title'           => 'required|string|max:255',
            'destination_url' => 'required|url',
            'icon'            => 'nullable|string',
            'display_as'      => 'nullable|in:button,social',
        ]);

        $settings = $link->settings ?? [];
        $settings['icon'] = $request->icon;
        $settings['display_as'] = $request->display_as ?? 'button';

        $link->update([
            'title'           => $request->title,
            'destination_url' => $request->destination_url,
            'is_active'       => $request->boolean('is_active'),
            'settings'        => $settings,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Link berhasil diperbarui',
                'data' => $link
            ]);
        }

        return back()->with('success', 'Link berhasil diperbarui.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array']);

        foreach ($request->ids as $index => $id) {
            Link::where('id', $id)
                ->where('user_id', Auth::id())
                ->update(['order' => $index]);
        }

        return response()->json(['status' => 'success']);
    }

    public function destroy(Request $request, Link $link)
    {
        if ($link->page->user_id !== auth()->id()) {
            abort(403);
        }

        $link->delete();
        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Link dihapus']);
        }

        return back()->with('success', 'Link berhasil dihapus.');
    }
}
