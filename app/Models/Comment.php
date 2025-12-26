<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar en masa.
     */
    protected $fillable = [
        'task_id',
        'user_id',
        'content',
    ];

    // ==========================================
    // RELACIONES
    // ==========================================

    /**
     * Relación: Un comentario pertenece a una tarea
     * Belongs-to (inversa de hasMany)
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Relación: Un comentario es escrito por un usuario
     * Belongs-to (inversa de hasMany)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
