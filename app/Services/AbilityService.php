<?php

namespace App\Services;

use App\Models\Ability;
use Illuminate\Database\Eloquent\Collection;

class AbilityService
{
    public function getAll(): Collection
    {
        return Ability::all();
    }

    public function getById(int $id): Ability
    {
        return Ability::findOrFail($id);
    }

    public function create(array $data): Ability
    {
        return Ability::create($data);
    }

    public function update(Ability $ability, array $data): Ability
    {
        $ability->update($data);
        return $ability->fresh();
    }

    public function delete(Ability $ability): bool
    {
        return $ability->delete();
    }
}
