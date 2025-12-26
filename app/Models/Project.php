<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;


    protected $fillable = [
    'team_id',
    'name',
    'description',
    ];


public function team()
{

return $this->belongsTo(Team::class);

}

public function tasks()
{

return $this->hasMany(Task::class);

}

public function creator()
{
    return $this->belongsTo(User::class, 'creator_id');
}

// ==========================================
    // SCOPES (Consultas reutilizables)
    // ==========================================

    /**
     * Scope: Filtrar proyectos por equipo
     * Uso: Project::byTeam(1)->get()
     */


     public function scopeByTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }


}




