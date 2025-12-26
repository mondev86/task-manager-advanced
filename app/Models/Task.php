<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'project_id',
        'status',
        'priority',
        'due_date',
        'created_by',
        'assigned_to',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    /**
     * Accessor para que "name" retorne "title"
     */
    public function getNameAttribute()
    {
        return $this->title;
    }

    /**
     * Accessor para que "creator" retorne "createdBy"
     */
    public function getCreatorAttribute()
    {
        return $this->createdBy;
    }

    /**
     * Accessor para que "assignedTo" retorne el usuario asignado
     */
    public function getAssignedToAttribute()
    {
        if ($this->relationLoaded('assignedUser')) {
            return $this->getRelationValue('assignedUser');
        }
        return null;
    }

    // Relaciones
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
