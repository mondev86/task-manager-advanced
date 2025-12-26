<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Mostrar lista de comentarios de una tarea (index)
     * GET /tasks/{task}/comments
     *
     * @param Task $task
     */
    public function index(Task $task)
    {
        if (!Auth::user()->teams->contains($task->project->team)) {
            abort(403, 'No tienes acceso a esta tarea');
        }

        /** @var Comment[]|\Illuminate\Pagination\Paginator */
        $comments = $task->comments()->with('user')->paginate(20);

        return response()->json([
            'comments' => $comments,
        ]);
    }

    /**
     * Guardar nuevo comentario en BD (store)
     * POST /tasks/{task}/comments
     *
     * @param Request $request
     * @param Task $task
     */
    public function store(Request $request, Task $task)
    {
        if (!Auth::user()->teams->contains($task->project->team)) {
            abort(403, 'No tienes acceso a esta tarea');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:1|max:1000',
        ]);

        /** @var Comment */
        $comment = $task->comments()->create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        $comment->load('user');

        return back()->with('success', 'Comentario agregado exitosamente');
    }

    /**
     * Mostrar un comentario específico (show)
     * GET /comments/{comment}
     *
     * @param Comment $comment
     */
    public function show(Comment $comment)
    {
        if (!Auth::user()->teams->contains($comment->task->project->team)) {
            abort(403, 'No tienes acceso a este comentario');
        }

        $comment->load('user', 'task');

        return response()->json([
            'comment' => $comment,
        ]);
    }

    /**
     * Mostrar formulario para editar comentario (edit)
     * GET /comments/{comment}/edit
     *
     * @param Comment $comment
     */
    public function edit(Comment $comment)
    {
        if (!Auth::user()->teams->contains($comment->task->project->team)) {
            abort(403, 'No tienes acceso a este comentario');
        }

        /** @var int */
        $userId = Auth::id();

        if ($comment->user_id !== $userId) {
            abort(403, 'Solo puedes editar tus propios comentarios');
        }

        return response()->json([
            'comment' => $comment,
        ]);
    }

    /**
     * Actualizar comentario en BD (update)
     * PUT /comments/{comment}
     *
     * @param Request $request
     * @param Comment $comment
     */
    public function update(Request $request, Comment $comment)
    {
        if (!Auth::user()->teams->contains($comment->task->project->team)) {
            abort(403, 'No tienes acceso a este comentario');
        }

        /** @var int */
        $userId = Auth::id();

        if ($comment->user_id !== $userId) {
            abort(403, 'Solo puedes editar tus propios comentarios');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:1|max:1000',
        ]);

        $comment->update($validated);

        return back()->with('success', 'Comentario actualizado exitosamente');
    }

    /**
     * Eliminar comentario (destroy)
     * DELETE /comments/{comment}
     *
     * @param Comment $comment
     */
    public function destroy(Comment $comment)
    {
        if (!Auth::user()->teams->contains($comment->task->project->team)) {
            abort(403, 'No tienes acceso a este comentario');
        }

        /** @var int */
        $userId = Auth::id();

        if ($comment->user_id !== $userId) {
            abort(403, 'Solo puedes eliminar tus propios comentarios');
        }

        $comment->delete();

        return back()->with('success', 'Comentario eliminado exitosamente');
    }
}
