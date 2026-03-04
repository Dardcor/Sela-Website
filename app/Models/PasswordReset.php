<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordReset extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'token_hash',
        'expired_at',
        'used_at',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'expired_at' => 'datetime',
            'used_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
