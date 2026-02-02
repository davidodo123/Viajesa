<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    /**
     * Guarda un nuevo comentario (solo si ha reservado)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idvacacion' => 'required|exists:vacaciones,id',
            'texto' => 'required|string|min:10|max:1000'
        ]);

        try {
            // Verificar que el usuario ha reservado esta vacación
            $haReservado = Auth::user()->haReservado($validated['idvacacion']);
            
            if (!$haReservado) {
                return back()->with('error', 'Debes reservar esta vacación antes de comentar.');
            }

            Comentario::create([
                'iduser' => Auth::id(),
                'idvacacion' => $validated['idvacacion'],
                'texto' => $validated['texto']
            ]);

            return back()->with('success', 'Comentario publicado exitosamente.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al publicar el comentario: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza un comentario (solo el propietario)
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'texto' => 'required|string|min:10|max:1000'
        ]);

        try {
            $comentario = Comentario::where('id', $id)
                ->where('iduser', Auth::id())
                ->firstOrFail();

            $comentario->update($validated);

            return back()->with('success', 'Comentario actualizado exitosamente.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el comentario: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un comentario (solo el propietario o admin)
     */
    public function destroy($id)
    {
        try {
            $comentario = Comentario::findOrFail($id);

            // Solo el propietario o admin pueden eliminar
            if ($comentario->iduser != Auth::id() && !Auth::user()->isAdmin()) {
                abort(403, 'No tienes permiso para eliminar este comentario.');
            }

            $comentario->delete();

            return back()->with('success', 'Comentario eliminado exitosamente.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el comentario: ' . $e->getMessage());
        }
    }
}