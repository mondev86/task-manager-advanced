<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Estadísticas del usuario
        $teamsCount = $user->teams()->count();
        $projectsCount = $user->teams()
            ->with('projects')
            ->get()
            ->pluck('projects')
            ->flatten()
            ->count();

        // Tareas totales
        $tasksCount = Task::whereHas('project', function ($q) {
            $q->whereIn('team_id', Auth::user()->teams()->pluck('teams.id'));
        })->count();

        // Tareas por estado
        $tasksByStatus = [
            'pending' => Task::whereHas('project', function ($q) {
                $q->whereIn('team_id', Auth::user()->teams()->pluck('teams.id'));
            })->where('status', 'pending')->count(),
            'in_progress' => Task::whereHas('project', function ($q) {
                $q->whereIn('team_id', Auth::user()->teams()->pluck('teams.id'));
            })->where('status', 'in_progress')->count(),
            'completed' => Task::whereHas('project', function ($q) {
                $q->whereIn('team_id', Auth::user()->teams()->pluck('teams.id'));
            })->where('status', 'completed')->count(),
        ];

        // Tareas asignadas al usuario
        $myTasks = Task::where('assigned_to', $user->id)
            ->with(['project', 'creator'])
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        // Equipos recientes
        $recentTeams = $user->teams()
            ->with('projects')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return Inertia::render('Dashboard', [
            'teamsCount' => $teamsCount,
            'projectsCount' => $projectsCount,
            'tasksCount' => $tasksCount,
            'tasksByStatus' => $tasksByStatus,
            'myTasks' => $myTasks,
            'recentTeams' => $recentTeams,
        ]);
    }
}
