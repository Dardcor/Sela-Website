<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ability extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function userAbilities(): HasMany
    {
        return $this->hasMany(UserAbility::class);
    }

    public function requiredBySubTasks(): HasMany
    {
        return $this->hasMany(SubTask::class, 'required_ability_id');
    }
}
