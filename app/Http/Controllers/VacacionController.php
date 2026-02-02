<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacacionController extends Controller
{
    /**
     * Muestra el listado de vacaciones con filtros, ordenación y paginación
     */
    public function index(Request $request)
    {
        try {
            $query = Vacacion::with(['tipo', 'fotos']);

            // FILTRO 1: Por tipo
            if ($request->filled('tipo')) {
                $query->where('idtipo', $request->tipo);
            }

            // FILTRO 2: Por país
            if ($request->filled('pais')) {
                $query->where('pais', 'like', '%' . $request->pais . '%');
            }

            // FILTRO 3: Por rango de precio
            if ($request->filled('precio_min')) {
                $query->where('precio', '>=', $request->precio_min);
            }
            if ($request->filled('precio_max')) {
                $query->where('precio', '<=', $request->precio_max);
            }

            // FILTRO 4: Búsqueda por título
            if ($request->filled('buscar')) {
                $query->where('titulo', 'like', '%' . $request->buscar . '%');
            }

            // Ordenación
            $orden = $request->get('orden', 'recientes');
            switch ($orden) {
                case 'precio_asc':
                    $query->orderBy('precio', 'asc');
                    break;
                case 'precio_desc':
                    $query->orderBy('precio', 'desc');
                    break;
                case 'alfabetico':
                    $query->orderBy('titulo', 'asc');
                    break;
                case 'recientes':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            // Paginación
            $vacaciones = $query->paginate(9)->withQueryString();
            
            // Obtener tipos para el filtro
            $tipos = Tipo::all();
            
            // Obtener países únicos para el filtro
            $paises = Vacacion::select('pais')->distinct()->pluck('pais');

            return view('vacaciones.index', compact('vacaciones', 'tipos', 'paises'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar las vacaciones: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el detalle de una vacación específica
     */
    public function show($id)
    {
        try {
            $vacacion = Vacacion::with(['tipo', 'fotos', 'comentarios.usuario'])
                ->findOrFail($id);
            
            // Verificar si el usuario actual ha reservado
            $haReservado = false;
            if (Auth::check()) {
                $haReservado = Auth::user()->haReservado($id);
            }

            return view('vacaciones.show', compact('vacacion', 'haReservado'));
            
        } catch (\Exception $e) {
            return redirect()->route('vacaciones.index')
                ->with('error', 'Vacación no encontrada.');
        }
    }

    /**
     * Formulario para crear nueva vacación (solo admin)
     */
    public function create()
    {
        try {
            $tipos = Tipo::all();
            return view('vacaciones.create', compact('tipos'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
    }

    /**
     * Guarda una nueva vacación (solo admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'pais' => 'required|string|max:100',
            'idtipo' => 'required|exists:tipos,id',
            'fotos.*' => 'nullable|image|max:2048'
        ]);

        try {
            $vacacion = Vacacion::create($validated);

            // Subir fotos si existen
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $ruta = $foto->store('vacaciones', 'public');
                    $vacacion->fotos()->create(['ruta' => $ruta]);
                }
            }

            return redirect()->route('vacaciones.index')
                ->with('success', 'Vacación creada exitosamente.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al crear la vacación: ' . $e->getMessage());
        }
    }

    /**
     * Formulario para editar vacación (solo admin)
     */
    public function edit($id)
    {
        try {
            $vacacion = Vacacion::with('fotos')->findOrFail($id);
            $tipos = Tipo::all();
            return view('vacaciones.edit', compact('vacacion', 'tipos'));
        } catch (\Exception $e) {
            return redirect()->route('vacaciones.index')
                ->with('error', 'Vacación no encontrada.');
        }
    }

    /**
     * Actualiza una vacación (solo admin)
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'pais' => 'required|string|max:100',
            'idtipo' => 'required|exists:tipos,id',
        ]);

        try {
            $vacacion = Vacacion::findOrFail($id);
            $vacacion->update($validated);

            return redirect()->route('vacaciones.show', $id)
                ->with('success', 'Vacación actualizada exitosamente.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al actualizar la vacación: ' . $e->getMessage());
        }
    }

    /**
     * Elimina una vacación (solo admin)
     */
    public function destroy($id)
    {
        try {
            $vacacion = Vacacion::findOrFail($id);
            $vacacion->delete();

            return redirect()->route('vacaciones.index')
                ->with('success', 'Vacación eliminada exitosamente.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la vacación: ' . $e->getMessage());
        }
    }
}