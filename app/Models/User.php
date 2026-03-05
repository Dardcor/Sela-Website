<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'class',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function abilities(): HasMany
    {
        return $this->hasMany(UserAbility::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function subTaskAssignments(): HasMany
    {
        return $this->hasMany(SubTaskAssignment::class);
    }

    public function uploadedFiles(): HasMany
    {
        return $this->hasMany(SupportFile::class, 'uploaded_by');
    }

    public function taskGenerations(): HasMany
    {
        return $this->hasMany(TaskGeneration::class, 'generated_by');
    }

    public function passwordResets(): HasMany
    {
        return $this->hasMany(PasswordReset::class);
    }

    public function userSessions(): HasMany
    {
        return $this->hasMany(UserSession::class);
    }

    public function etholSession(): HasOne
    {
        return $this->hasOne(UserEtholSession::class);
    }
}
