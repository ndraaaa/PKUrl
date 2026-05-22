<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function index()
    {
        $ads = Advertisement::latest()->get();
        return view('admin.advertisements.index', compact('ads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'target_url' => 'nullable|url',
            'image' => 'required|image|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'target_url' => $request->target_url,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('ads', 'public');
        }

        Advertisement::create($data);
        return back()->with('success', 'Iklan berhasil ditambah!');
    }

    public function update(Request $request, $id)
    {
        $ad = Advertisement::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'target_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'target_url' => $request->target_url,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($ad->image_path) Storage::disk('public')->delete($ad->image_path);
            $data['image_path'] = $request->file('image')->store('ads', 'public');
        }

        $ad->update($data);
        return back()->with('success', 'Iklan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ad = Advertisement::findOrFail($id);
        if ($ad->image_path) Storage::disk('public')->delete($ad->image_path);
        $ad->delete();

        return back()->with('success', 'Iklan berhasil dihapus!');
    }
}
