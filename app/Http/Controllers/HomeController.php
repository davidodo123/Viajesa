<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Mostrar página principal
     */
    public function index(): View
    {
        return view('home');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(): View
    {
        return view('auth.edit');
    }

    /**
     * Actualizar datos del usuario
     */
    public function update(Request $request): RedirectResponse
    {
        // Validación de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.max' => 'El nombre no puede tener más de 255 caracteres',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está registrado',
        ]);

        try {
            // Usar DB para actualizar directamente
            DB::table('users')
                ->where('id', Auth::id())
                ->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'updated_at' => now(),
                ]);

            return redirect()->route('home')->with('success', 'Usuario guardado correctamente');
            
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }
}