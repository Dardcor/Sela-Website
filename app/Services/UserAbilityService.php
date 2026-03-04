<?php

namespace App\Services;

use App\Models\UserAbility;
use Illuminate\Database\Eloquent\Collection;

class UserAbilityService
{
    public function getUserAbilities(int $userId): Collection
    {
        return UserAbility::with('ability')->where('user_id', $userId)->get();
    }

    public function create(array $data): UserAbility
    {
        return UserAbility::create($data);
    }

    public function getById(int $id): UserAbility
    {
        return UserAbility::findOrFail($id);
    }

    public function update(UserAbility $userAbility, array $data): UserAbility
    {
        $userAbility->update($data);
        return $userAbility->fresh();
    }

    public function delete(UserAbility $userAbility): bool
    {
        return $userAbility->delete();
    }
}
