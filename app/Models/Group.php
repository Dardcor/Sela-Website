<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $fillable = [
        'name',
        'course',
        'max_member',
        'invitation_code',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
