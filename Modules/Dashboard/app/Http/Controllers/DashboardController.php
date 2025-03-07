<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Models\User;
use Modules\Risk\Models\Risk;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Statistik Pengguna
            $totalUsers = User::count();
            $activeUsers = User::where('status', 'active')->count();
            $inactiveUsers = User::where('status', 'inactive')->count();
            $userActivityPercentage = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 2) : 0;

            $usersByDivision = User::with('division')
                ->select(
                    'division_id',
                    DB::raw('count(*) as total'),
                    DB::raw('SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_count')
                )
                ->groupBy('division_id')
                ->get()
                ->map(function ($user) {
                    $user->division_name = $user->division->name ?? 'Unassigned';
                    $user->active_percentage = $user->total > 0 ?
                        round(($user->active_count / $user->total) * 100, 2) : 0;
                    return $user;
                });

            // Statistik Risiko
            $totalRisks = Risk::count();
            $openRisks = Risk::where('risk_status', 'Open')->count();
            $closedRisks = Risk::where('risk_status', 'Closed')->count();
            $pendingReviews = Risk::where('next_review_date', '<', now())
                ->where('risk_status', 'Open')
                ->count();

            // Calculate risk resolution rate
            $riskResolutionRate = $totalRisks > 0 ?
                round(($closedRisks / $totalRisks) * 100, 2) : 0;

            // Get trends - risks created in the last 30 days
            $recentRisks = Risk::where('created_at', '>=', now()->subDays(30))
                ->count();
            $recentClosedRisks = Risk::where('created_at', '>=', now()->subDays(30))
                ->where('risk_status', 'Closed')
                ->count();

            // Statistik Risiko Berdasarkan Level Kontrol 
            $controlStats = Risk::with('division')
                ->select('division_id', DB::raw('COUNT(id) as total'), 'control')
                ->groupBy('division_id', 'control')
                ->get()
                ->groupBy(function ($risk) {
                    return $risk->division->name ?? 'Unassigned';
                });

            // Control effectiveness by level
            $controlEffectiveness = Risk::select('control', DB::raw('COUNT(id) as total'))
                ->groupBy('control')
                ->orderBy('control')
                ->get();

            // Grafik Status Risiko
            $riskStatuses = Risk::select(DB::raw('COUNT(id) as total, risk_status'))
                ->groupBy('risk_status')
                ->pluck('total', 'risk_status');

            // Most recent risks
            $latestRisks = Risk::with('division')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('dashboard::index', [
                'title' => 'Dashboard',
                // User statistics
                'totalUsers' => $totalUsers,
                'activeUsers' => $activeUsers,
                'inactiveUsers' => $inactiveUsers,
                'userActivityPercentage' => $userActivityPercentage,
                'usersByDivision' => $usersByDivision,

                // Risk statistics
                'totalRisks' => $totalRisks,
                'openRisks' => $openRisks,
                'closedRisks' => $closedRisks,
                'pendingReviews' => $pendingReviews,
                'riskResolutionRate' => $riskResolutionRate,
                'recentRisks' => $recentRisks,
                'recentClosedRisks' => $recentClosedRisks,

                // Detailed statistics
                'controlStats' => $controlStats,
                'controlEffectiveness' => $controlEffectiveness,
                'riskStatuses' => $riskStatuses,
                'latestRisks' => $latestRisks,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading dashboard data: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'stack' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Gagal memuat data dashboard. Silakan coba lagi.');
        }
    }

    public function create()
    {
        return view('dashboard::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('dashboard::show');
    }

    public function edit($id)
    {
        return view('dashboard::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
