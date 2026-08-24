<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wash;
use Carbon\Carbon;

class ReceptionController extends Controller
{
    public function index()
    {
        $host = Auth::user();
        $washers = User::where('role', 'washer')->get();

        // Stats dinámicos del día
        $todayWashes = Wash::whereDate('created_at', Carbon::today())->count();
        $todayRevenue = Wash::whereDate('created_at', Carbon::today())->sum('price');
        $todayCompleted = Wash::whereDate('created_at', Carbon::today())
            ->where('status', 'completed')->count();

        // Vehículos en proceso
        $inProgressWashes = Wash::with('washer')
            ->where('status', 'in_progress')
            ->latest()
            ->get();

        return view('reception', compact(
            'host', 'washers', 'todayWashes', 'todayRevenue',
            'todayCompleted', 'inProgressWashes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_type' => 'required',
            'plate_number' => 'required',
            'washer_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('vehicles', 'public');
        }

        // Obtener el porcentaje del lavador
        $washer = User::find($request->washer_id);
        $commission = ($request->price * $washer->commission_rate) / 100;

        Wash::create([
            'host_id' => Auth::id(),
            'washer_id' => $request->washer_id,
            'vehicle_type' => $request->vehicle_type,
            'plate_number' => $request->plate_number,
            'color' => $request->color,
            'details' => $request->details,
            'photo_path' => $photoPath,
            'price' => $request->price,
            'payment_method' => $request->payment_method,
            'washer_payment' => $commission,
            'status' => 'in_progress',
        ]);

        return redirect('/reception')->with('success', '¡Vehículo registrado exitosamente!');
    }

    /**
     * Actualizar el estado de un lavado.
     */
    public function updateStatus(Request $request, Wash $wash)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $wash->update(['status' => $request->status]);

        return back()->with('success', 'Estado actualizado correctamente.');
    }
}
