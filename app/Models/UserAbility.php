<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAbility extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'ability_id',
        'level',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ability(): BelongsTo
    {
        return $this->belongsTo(Ability::class);
    }
}
