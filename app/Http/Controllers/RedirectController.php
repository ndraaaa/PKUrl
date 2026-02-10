<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Page;
use App\Models\Analytics;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent; // Optional: Install library jenssegers/agent untuk deteksi device

class RedirectController extends Controller
{
    public function handle($path)
    {
        $link = Link::where('short_code', $path)->first();
        if ($link && $link->isValid()) {
            $this->recordVisit($link);
            return redirect()->away($link->destination_url);
        }
        $page = Page::where('handle', $path)->first();

        if ($page && $page->is_public) {
            $page->load(['links' => function ($q) {
                $q->where('is_active', true)->orderBy('order');
            }]);

            return view('pages.public-bio', compact('page'));
        }
        abort(404);
    }

    private function recordVisit($link)
    {
        $link->increment('click_count');
        $agent = new Agent();

        Analytics::create([
            'link_id'      => $link->id,
            'ip_address'   => request()->ip(),
            'country_code' => 'ID',
            'device'       => $agent->device(), 
            'browser'      => $agent->browser(),
            'os'           => $agent->platform(),
            'referer'      => request()->header('referer'),
        ]);
    }
}
