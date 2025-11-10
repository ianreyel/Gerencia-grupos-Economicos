<?php

namespace App\Policies;

use App\Models\GrupoEconomico;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class GrupoEconomicoPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->is_admin === 1;
    }

    public function update(User $user, GrupoEconomico $grupoEconomico)
    {
        return $user->is_admin === 1;
    }


    public function delete(User $user, GrupoEconomico $grupoEconomico)
    {
        return $user->is_admin === 1;
    }


    public function viewAny(User $user)
    {
        return true;
    }
}