<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Mostrar lista de proyectos de un equipo
     * GET /teams/{team}/projects
     */
 public function index(Team $team)
{
    $isMember = Auth::user()->teams()->pluck('teams.id')->contains($team->id);

    if (!$isMember) {
        abort(403, 'No tienes acceso a este equipo');
    }

    $projects = $team->projects()
        ->with('creator')
        ->withCount('tasks')
        ->paginate(9);

    return Inertia::render('Projects/Index', [
        'team' => $team,
        'projects' => $projects,
        'userIsAdmin' => Auth::user()->isAdmin(),
    ]);
}

    /**
     * Mostrar formulario para crear proyecto
     * GET /teams/{team}/projects/create
     */
    public function create(Team $team)
    {
        // Solo admins y super_admins pueden crear proyectos
        if (!Auth::user()->isAdmin()) {
            abort(403, 'No tienes permisos para crear proyectos');
        }

        return Inertia::render('Projects/Create', ['team' => $team]);
    }

    /**
     * Guardar nuevo proyecto
     * POST /teams/{team}/projects
     */
    public function store(Request $request, Team $team)
    {
        // Verificar autorización
        if (!Auth::user()->isAdmin()) {
            abort(403, 'No tienes permisos para crear proyectos');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $project = $team->projects()->create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Proyecto creado exitosamente');
    }

    /**
     * Mostrar detalles de un proyecto
     * GET /projects/{project}
     */
    public function show(Project $project)
    {
        // Verificar que el usuario pertenece al equipo del proyecto
        if (!Auth::user()->teams()->where('team_id', $project->team_id)->exists()) {
            abort(403, 'No tienes acceso a este proyecto');
        }

        $project->load(['team', 'creator', 'tasks']);

        return Inertia::render('Projects/Show', ['project' => $project]);
    }

    /**
     * Mostrar formulario para editar proyecto
     * GET /projects/{project}/edit
     */
  public function edit(Project $project)
{
    if (Auth::id() !== $project->created_by && !Auth::user()->isAdmin()) {
        abort(403, 'No tienes permisos para editar este proyecto');
    }

    return Inertia::render('Projects/Edit', [
        'project' => $project,
        'userIsAdmin' => Auth::user()->isAdmin(),
    ]);
}

    /**
     * Actualizar proyecto
     * PUT /projects/{project}
     */
    public function update(Request $request, Project $project)
    {
        // Verificar autorización
        if (Auth::id() !== $project->created_by && !Auth::user()->isAdmin()) {
            abort(403, 'No tienes permisos para editar este proyecto');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $project->update($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Proyecto actualizado');
    }

    /**
     * Eliminar proyecto
     * DELETE /projects/{project}
     */
    public function destroy(Project $project)
    {
        // Verificar autorización: solo el creador o super_admin pueden eliminar
        if (Auth::id() !== $project->created_by && !Auth::user()->isSuperAdmin()) {
            abort(403, 'No tienes permisos para eliminar este proyecto');
        }

        $team = $project->team;
        $project->delete();

        return redirect()->route('projects.index', ['team' => $team])->with('success', 'Proyecto eliminado');
    }
}
