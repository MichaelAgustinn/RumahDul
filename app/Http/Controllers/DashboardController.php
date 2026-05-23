<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\ModulLog;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        // Tangkap parameter filter dari URL (default: 7_days)
        $period = $request->query('period', '7_days');

        // 1. DATA SUMMARY (Tetap Hitung Harian/Bulanan Secara Universal)
        $summary = [
            'visitors_today' => Visitor::where('visit_date', $today->toDateString())->count(),
            'visitors_month' => Visitor::whereMonth('visit_date', $today->month)
                ->whereYear('visit_date', $today->year)->count(),
            'views_today' => ModulLog::whereDate('created_at', $today)->where('type', 'view')->count(),
            'downloads_today' => ModulLog::whereDate('created_at', $today)->where('type', 'download')->count(),
        ];

        // 2. DATA GRAFIK BERDASARKAN FILTER
        $labels = [];
        $visitors = [];
        $views = [];
        $downloads = [];

        if ($period == 'this_month') {
            // --- FILTER: BULAN INI (Grafik menampilkan tgl 1 s/d hari ini) ---
            $daysInMonth = $today->daysInMonth;

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $date = Carbon::now()->setDay($i);

                // Hentikan loop jika tanggal tersebut belum terjadi (masa depan)
                if ($date->isFuture()) break;

                $labels[] = $date->format('d') . ' ' . $date->translatedFormat('M'); // Contoh: 01 Mei
                $visitors[] = Visitor::where('visit_date', $date->toDateString())->count();
                $views[] = ModulLog::whereDate('created_at', $date)->where('type', 'view')->count();
                $downloads[] = ModulLog::whereDate('created_at', $date)->where('type', 'download')->count();
            }
        } elseif ($period == 'this_year') {
            // --- FILTER: TAHUN INI (Grafik menampilkan Bulan Jan s/d bulan ini) ---
            for ($i = 1; $i <= 12; $i++) {
                $date = Carbon::now()->setMonth($i);

                // Hentikan loop jika bulan tersebut belum terjadi di tahun ini
                if ($i > $today->month && $date->year == $today->year) break;

                $labels[] = $date->translatedFormat('F'); // Contoh: Januari, Februari

                // Perhatikan: Karena per bulan, kita pakai whereMonth dan whereYear, BUKAN whereDate
                $visitors[] = Visitor::whereMonth('visit_date', $i)->whereYear('visit_date', $today->year)->count();
                $views[] = ModulLog::whereMonth('created_at', $i)->whereYear('created_at', $today->year)->where('type', 'view')->count();
                $downloads[] = ModulLog::whereMonth('created_at', $i)->whereYear('created_at', $today->year)->where('type', 'download')->count();
            }
        } else {
            // --- FILTER: 7 HARI TERAKHIR (Default) ---
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);

                $labels[] = $date->translatedFormat('d M');
                $visitors[] = Visitor::where('visit_date', $date->toDateString())->count();
                $views[] = ModulLog::whereDate('created_at', $date)->where('type', 'view')->count();
                $downloads[] = ModulLog::whereDate('created_at', $date)->where('type', 'download')->count();
            }
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
