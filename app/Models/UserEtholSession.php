<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEtholSession extends Model
{
    protected $fillable = [
        'user_id',
        'ethol_token',
        'ethol_cookies',
    ];

    protected function casts(): array
    {
        return [
            'ethol_token' => 'encrypted',
            'ethol_cookies' => 'encrypted',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
