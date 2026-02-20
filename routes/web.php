<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile redirects
    Route::get('/profile', function () {
        return redirect('/settings/profile');
    })->name('profile');

    Route::patch('/profile', function () {
        return redirect()->route('profile.update');
    });

    Route::delete('/profile', function () {
        return redirect()->route('profile.destroy');
    });

    // Rutas de Teams
    Route::resource('teams', TeamController::class);

    // Rutas de Projects
    Route::get('/teams/{team}/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/teams/{team}/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/teams/{team}/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Rutas de Tasks dentro de Projects
    Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/projects/{project}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');

    // Rutas de Tasks individuales
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])
        ->name('tasks.index');


    // Rutas de Comentarios
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
