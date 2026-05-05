<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Page;
use App\Models\Analytics;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class RedirectController extends Controller
{
    public function handle($path)
    {
        $link = Link::where('short_code', $path)->first();
        if ($link && $link->isValid()) {
            $this->recordVisit($link);
            return view('pages.splash', compact('link'));
        }

        $page = Page::where('handle', $path)->first();

        if ($page && $page->is_public) {
            $page->load(['links' => function ($q) {
                $q->where('is_active', true)->orderBy('order');
            }]);

            return view('pages.public-bio', compact('page'));
        }

        abort(404, 'Halaman/Link tidak ditemukan atau sedang dinonaktifkan.');
    }

    private function recordVisit($link)
    {
        $agent = new Agent();
        if ($agent->isRobot()) {
            return;
        }

        $link->increment('click_count');

        Analytics::create([
            'link_id'      => $link->id,
            'ip_address'   => request()->ip(),
            'country_code' => 'ID',
            'device'       => $agent->device() ?: 'Unknown',
            'browser'      => $agent->browser() ?: 'Unknown',
            'os'           => $agent->platform() ?: 'Unknown',
            'referer'      => request()->header('referer'),
        ]);
    }
}
