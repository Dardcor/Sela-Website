<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'title',
        'type',
        'description',
        'deadline',
        'group_id',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function subTasks(): HasMany
    {
        return $this->hasMany(SubTask::class);
    }

    public function supportFiles(): HasMany
    {
        return $this->hasMany(SupportFile::class);
    }

    public function generations(): HasMany
    {
        return $this->hasMany(TaskGeneration::class);
    }
}
