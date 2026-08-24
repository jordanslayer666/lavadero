<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wash;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Totales generales
        $totalWashes = Wash::count();
        $totalRevenue = Wash::sum('price');
        $totalInvested = Wash::sum('washer_payment');
        $netProfit = $totalRevenue - $totalInvested;

        // Pendientes (en progreso)
        $pendingCount = Wash::where('status', 'in_progress')->count();

        // Historial reciente
        $recentWashes = Wash::with(['washer', 'host'])->latest()->limit(15)->get();

        // Ranking de lavadores
        $washersRanking = User::where('role', 'washer')
            ->withCount('washes')
            ->get()
            ->sortByDesc('washes_count');

        // Datos para gráfico mensual (últimos 6 meses)
        $monthlyData = [];
        $monthLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabels[] = $date->translatedFormat('M');
            $monthlyData[] = Wash::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Ingresos de hoy
        $todayRevenue = Wash::whereDate('created_at', Carbon::today())->sum('price');
        $todayWashes = Wash::whereDate('created_at', Carbon::today())->count();

        return view('admin', compact(
            'totalWashes', 'totalRevenue', 'totalInvested', 'netProfit',
            'pendingCount', 'recentWashes', 'washersRanking',
            'monthlyData', 'monthLabels', 'todayRevenue', 'todayWashes'
        ));
    }

    /**
     * Eliminar un registro de lavado.
     */
    public function destroyWash(Wash $wash)
    {
        $wash->delete();
        return back()->with('success', 'Registro eliminado correctamente.');
    }
}
