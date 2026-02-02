<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Vacacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    /**
     * Realiza una reserva (requiere email verificado)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idvacacion' => 'required|exists:vacaciones,id'
        ]);

        try {
            // Verificar que no exista ya una reserva
            $existente = Reserva::where('iduser', Auth::id())
                ->where('idvacacion', $validated['idvacacion'])
                ->first();

            if ($existente) {
                return back()->with('warning', 'Ya has reservado esta vacación.');
            }

            Reserva::create([
                'iduser' => Auth::id(),
                'idvacacion' => $validated['idvacacion']
            ]);

            return back()->with('success', '¡Reserva realizada con éxito!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al realizar la reserva: ' . $e->getMessage());
        }
    }

    /**
     * Muestra las reservas del usuario autenticado
     */
    public function misReservas()
    {
        try {
            $reservas = Reserva::with(['vacacion.fotos', 'vacacion.tipo'])
                ->where('iduser', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('reservas.mis-reservas', compact('reservas'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar las reservas: ' . $e->getMessage());
        }
    }

    /**
     * Cancela una reserva
     */
    public function destroy($id)
    {
        try {
            $reserva = Reserva::where('id', $id)
                ->where('iduser', Auth::id())
                ->firstOrFail();

            $reserva->delete();

            return back()->with('success', 'Reserva cancelada exitosamente.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cancelar la reserva: ' . $e->getMessage());
        }
    }

    /**
     * Lista todas las reservas (solo admin)
     */
    public function index()
    {
        try {
            $reservas = Reserva::with(['usuario', 'vacacion'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return view('reservas.index', compact('reservas'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar las reservas: ' . $e->getMessage());
        }
    }
}