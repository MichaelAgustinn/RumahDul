<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\ModulLog;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. DATA ANGKA (SUMMARY)
        $summary = [
            'visitors_today' => Visitor::where('visit_date', $today->toDateString())->count(),
            'visitors_month' => Visitor::whereMonth('visit_date', $today->month)
                ->whereYear('visit_date', $today->year)->count(),
            'views_today' => ModulLog::whereDate('created_at', $today)->where('type', 'view')->count(),
            'downloads_today' => ModulLog::whereDate('created_at', $today)->where('type', 'download')->count(),
        ];

        // 2. DATA GRAFIK (7 Hari Terakhir)
        $labels = [];
        $visitors = [];
        $views = [];
        $downloads = [];

        // Looping mundur dari 6 hari yang lalu sampai hari ini
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            // Format label (Contoh: 18 Mei, 19 Mei)
            $labels[] = $date->translatedFormat('d M');

            // Hitung data per hari
            $visitors[] = Visitor::where('visit_date', $date->toDateString())->count();
            $views[] = ModulLog::whereDate('created_at', $date)->where('type', 'view')->count();
            $downloads[] = ModulLog::whereDate('created_at', $date)->where('type', 'download')->count();
        }

        $chartData = [
            'labels' => $labels,
            'visitors' => $visitors,
            'views' => $views,
            'downloads' => $downloads,
        ];

        return view('admin.dashboard.index', compact('summary', 'chartData'));
    }
}
