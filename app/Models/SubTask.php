<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubTask extends Model
{
    protected $fillable = [
        'name',
        'task_id',
        'description',
        'required_ability_id',
        'generation_id',
        'status',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function requiredAbility(): BelongsTo
    {
        return $this->belongsTo(Ability::class, 'required_ability_id');
    }

    public function generation(): BelongsTo
    {
        return $this->belongsTo(TaskGeneration::class, 'generation_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(SubTaskAssignment::class);
    }
}
