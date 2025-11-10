<?php

namespace App\Policies;

use App\Models\Colaborador;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ColaboradorPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->is_admin === 1;
    }

    public function update(User $user, Colaborador $colaborador)
    {
        return $user->is_admin === 1;
    }

    public function delete(User $user, Colaborador $colaborador)
    {
        return $user->is_admin === 1;
    }

 
    public function viewAny(User $user)
    {
        return true;
    }
}