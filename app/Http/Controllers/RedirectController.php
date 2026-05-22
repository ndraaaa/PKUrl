<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Page;
use App\Models\Analytics;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RedirectController extends Controller
{
    public function handle($path)
    {
        $link = Link::where('short_code', $path)->first();

        if ($link && $link->isValid()) {
            $this->recordVisit($link);

            $agent = new Agent();
            $destination = $link->destination_url;

            if (Str::startsWith($destination, 'mailto:')) {
                if ($agent->isMobile() || $agent->isTablet()) {
                    return redirect()->away($destination);
                } else {
                    $email = str_replace('mailto:', '', $destination);
                    $destination = "https://mail.google.com/mail/?view=cm&fs=1&to=" . $email;
                    
                    $link->destination_url = $destination;
                }
            }

            if (Str::startsWith($destination, 'tel:')) {
                return redirect()->away($destination);
            }
            $ads = Advertisement::where('is_active', true)->get();

            return view('pages.splash', compact('link', 'ads'));
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
        try {
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
            
        } catch (\Exception $e) {
            Log::error('Analisis e-Link gagal dicatat: ' . $e->getMessage());
        }
    }
}