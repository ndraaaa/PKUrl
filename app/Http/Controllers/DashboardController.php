<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Page;
use App\Models\User;
use App\Models\Analytics;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // --- 1. LOGIK KHUSUS ADMIN ---
        $totalUsers = 0;
        // Ganti 'admin' sesuai pengecekan role di database Anda (misal: usertype, role, is_admin)
        if ($user->role === 'admin') {
            $totalUsers = User::count();
        }

        // --- 2. STATISTIK UMUM ---
        $totalLinks = Link::where('user_id', $user->id)->whereNull('page_id')->count();
        $totalPages = Page::where('user_id', $user->id)->count();
        $totalClicks = Link::where('user_id', $user->id)->sum('click_count');

        // --- 3. DATA POPULER & TERBARU ---
        $popularLinks = Link::where('user_id', $user->id)->orderByDesc('click_count')->limit(5)->get();
        $recentLinks = Link::where('user_id', $user->id)->latest()->limit(5)->get();

        // --- 4. DATA GRAFIK TERPISAH (Shortlink vs Bio Link) ---
        $chartLabels = [];
        $shortlinkData = [];
        $biolinkData = [];

        // Pisahkan ID Link milik user
        // Shortlink = Link yang TIDAK punya page_id
        $shortlinkIds = Link::where('user_id', $user->id)->whereNull('page_id')->pluck('id');
        // Bio Link = Link yang PUNYA page_id (tombol di dalam halaman)
        $biolinkIds = Link::where('user_id', $user->id)->whereNotNull('page_id')->pluck('id');

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $formattedDate = $date->format('Y-m-d');

            $chartLabels[] = $date->format('d M');

            // Hitung Shortlink Visits
            $shortlinkData[] = Analytics::whereIn('link_id', $shortlinkIds)
                ->whereDate('created_at', $formattedDate)
                ->count();

            // Hitung Bio Link Visits
            $biolinkData[] = Analytics::whereIn('link_id', $biolinkIds)
                ->whereDate('created_at', $formattedDate)
                ->count();
        }

        $chartData = [
            'labels' => $chartLabels,
            'shortlink' => $shortlinkData,
            'biolink' => $biolinkData
        ];

        return view('dashboard', compact(
            'totalUsers',
            'totalLinks',
            'totalPages',
            'totalClicks',
            'popularLinks',
            'recentLinks',
            'chartData'
        ));
    }

    public function getChartData(Request $request)
    {
        $user = Auth::user();
        $daysBack = $request->get('range') === 'month' ? 365 : 30;

        $endDate = Carbon::now()->endOfDay();
        $startDate = Carbon::now()->subDays($daysBack)->startOfDay();

        $shortlinkIds = Link::where('user_id', $user->id)->whereNull('page_id')->pluck('id');
        $biolinkIds = Link::where('user_id', $user->id)->whereNotNull('page_id')->pluck('id');

        $shortlinkSeries = [];
        $biolinkSeries = [];

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $timestamp = $date->timestamp * 1000;

            $countShort = Analytics::whereIn('link_id', $shortlinkIds)
                ->whereDate('created_at', $formattedDate)
                ->count();
            $shortlinkSeries[] = [$timestamp, $countShort];

            $countBio = Analytics::whereIn('link_id', $biolinkIds)
                ->whereDate('created_at', $formattedDate)
                ->count();
            $biolinkSeries[] = [$timestamp, $countBio];
        }

        return response()->json([
            'shortlink' => $shortlinkSeries,
            'biolink' => $biolinkSeries
        ]);
    }
}
