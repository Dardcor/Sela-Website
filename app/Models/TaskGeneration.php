<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskGeneration extends Model
{
    protected $fillable = [
        'task_id',
        'generated_by',
        'prompt',
        'ai_response',
        'model',
        'version',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function generator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function subTasks(): HasMany
    {
        return $this->hasMany(SubTask::class, 'generation_id');
    }
}
