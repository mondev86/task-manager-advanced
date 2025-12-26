<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/**
 * @method \Illuminate\Contracts\Auth\Authenticatable|null user()
 */
class TeamController extends Controller
{
    /**
     * Mostrar lista de equipos (index)
     * GET /teams
     */
 public function index()
{
    $teams = auth()->user()->teams()
        ->withCount(['projects', 'users'])
        ->paginate(9);

    return Inertia::render('Teams/Index', ['teams' => $teams]);
}

    /**
     * Mostrar formulario para crear equipo (create)
     * GET /teams/create
     */
    public function create()
    {
       return Inertia::render('Teams/Create');
    }

    /**
     * Guardar nuevo equipo en BD (store)
     * POST /teams
     */
    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Crear equipo con el usuario autenticado como creador
        $team = Team::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        // El creador se une automáticamente al equipo
        $team->users()->attach(Auth::id());

        return redirect()->route('teams.show', $team)->with('success', 'Equipo creado exitosamente');
    }

    /**
     * Mostrar un equipo específico (show)
     * GET /teams/{team}
     */
   public function show(Team $team)
{
    $team->load(['projects', 'users']);

    return Inertia::render('Teams/Show', ['team' => $team]);
}

    /**
     * Mostrar formulario para editar equipo (edit)
     * GET /teams/{team}/edit
     */
    public function edit(Team $team)
    {
        // Verificar autorización (solo el creador puede editar)
       $this->authorize('update', $team);
    return Inertia::render('Teams/Edit', ['team' => $team]);
    }

    /**
     * Actualizar equipo en BD (update)
     * PUT /teams/{team}
     */
   public function update(Request $request, Team $team)
{
    $this->authorize('update', $team);

    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'description' => 'nullable|string|max:500',
    ]);

    $team->update($validated);

    return redirect()->route('teams.show', $team);
}

    /**
     * Eliminar equipo (destroy)
     * DELETE /teams/{team}
     */
   public function destroy(Team $team)
{
    $this->authorize('delete', $team);

    $team->delete();

    return redirect()->route('teams.index');
 }
}
