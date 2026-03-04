<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubTaskAssignment extends Model
{
    protected $fillable = [
        'sub_task_id',
        'user_id',
        'role',
        'status',
    ];

    public function subTask(): BelongsTo
    {
        return $this->belongsTo(SubTask::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
