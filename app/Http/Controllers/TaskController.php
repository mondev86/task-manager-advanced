<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Mostrar lista de tareas de un proyecto (index)
     * GET /projects/{project}/tasks
     */
    public function index(Project $project)
    {
        // Verificar que el usuario sea miembro del equipo del proyecto
        if (!Auth::user()->teams->contains($project->team)) {
            abort(403, 'No tienes acceso a este proyecto');
        }

        // Obtener tareas del proyecto con relaciones
        $tasks = $project->tasks()
            ->with(['assignedUser', 'comments.user'])
            ->paginate(15);

        return Inertia::render('Tasks/Index', [
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }

    /**
     * Mostrar formulario para crear tarea (create)
     * GET /projects/{project}/tasks/create
     */
    public function create(Project $project)
    {
        // Verificar que el usuario sea miembro del equipo
        if (!Auth::user()->teams->contains($project->team)) {
            abort(403, 'No tienes acceso a este proyecto');
        }

        // Obtener miembros del equipo para asignar tareas
        $teamMembers = $project->team->users;

        return Inertia::render('Tasks/Create', [
            'project' => $project,
            'teamMembers' => $teamMembers,
        ]);
    }

    /**
     * Guardar nueva tarea en BD (store)
     * POST /projects/{project}/tasks
     */
    public function store(Request $request, Project $project)
    {
        // Verificar que el usuario sea miembro del equipo
        if (!Auth::user()->teams->contains($project->team)) {
            abort(403, 'No tienes acceso a este proyecto');
        }

        // Validar datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        // Crear tarea - mapear "name" a "title" en la BD
        $task = $project->tasks()->create([
            'title' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'] ?? null,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('tasks.show', $task)->with('success', 'Tarea creada exitosamente');
    }

    /**
     * Mostrar una tarea específica con sus comentarios (show)
     * GET /tasks/{task}
     */
  public function show(Task $task)
{
    // Verificar que el usuario sea miembro del equipo del proyecto
    if (!Auth::user()->teams->contains($task->project->team)) {
        abort(403, 'No tienes acceso a esta tarea');
    }

    // Cargar relaciones explícitamente
    $task->load([
        'project',
        'createdBy',
        'assignedUser',
        'comments.user',
    ]);

    // Renombrar las relaciones para Vue
    $taskArray = $task->toArray();
    $taskArray['created_by_user'] = $taskArray['created_by'] ?? null;
    $taskArray['assigned_user'] = $taskArray['assigned_user'] ?? null;

    return Inertia::render('Tasks/Show', [
        'task' => $taskArray,
        'userIsAdmin' => Auth::user()->isAdmin(),
    ]);
}

    /**
     * Mostrar formulario para editar tarea (edit)
     * GET /tasks/{task}/edit
     */
    public function edit(Task $task)
    {
        // Verificar que el usuario sea miembro del equipo
        if (!Auth::user()->teams->contains($task->project->team)) {
            abort(403, 'No tienes acceso a esta tarea');
        }

        // Obtener miembros del equipo
        $teamMembers = $task->project->team->users;

        return Inertia::render('Tasks/Edit', [
            'task' => $task,
            'teamMembers' => $teamMembers,
        ]);
    }

    /**
     * Actualizar tarea en BD (update)
     * PUT /tasks/{task}
     */
    public function update(Request $request, Task $task)
    {
        // Verificar que el usuario sea miembro del equipo
        if (!Auth::user()->teams->contains($task->project->team)) {
            abort(403, 'No tienes acceso a esta tarea');
        }

        // Validar datos
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:1000',
            'status' => 'sometimes|in:pending,in_progress,completed',
            'priority' => 'sometimes|in:low,medium,high',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        // Mapear "name" a "title" para la actualización
        $dataToUpdate = $validated;
        if (isset($dataToUpdate['name'])) {
            $dataToUpdate['title'] = $dataToUpdate['name'];
            unset($dataToUpdate['name']);
        }

        // Actualizar tarea
        $task->update($dataToUpdate);

        return redirect()->route('tasks.show', $task)->with('success', 'Tarea actualizada exitosamente');
    }

    /**
     * Eliminar tarea (destroy)
     * DELETE /tasks/{task}
     */
    public function destroy(Task $task)
    {
        // Verificar que el usuario sea miembro del equipo
        if (!Auth::user()->teams->contains($task->project->team)) {
            abort(403, 'No tienes acceso a esta tarea');
        }

        // Guardar el proyecto antes de eliminar
        $projectId = $task->project->id;

        // Eliminar tarea (y sus comentarios por cascade)
        $task->delete();

        return redirect()->route('projects.show', $projectId)->with('success', 'Tarea eliminada exitosamente');
    }

    /**
     * Actualizar solo el estado de una tarea (updateStatus)
     * PATCH /tasks/{task}/status
     */
    public function updateStatus(Request $request, Task $task)
    {
        // Verificar que el usuario sea miembro del equipo
        if (!Auth::user()->teams->contains($task->project->team)) {
            abort(403, 'No tienes acceso a esta tarea');
        }

        // Validar el nuevo estado
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // Actualizar solo el estado
        $task->update(['status' => $validated['status']]);

        return back()->with('success', 'Estado de tarea actualizado');
    }
}
