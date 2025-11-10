<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\GrupoEconomico;
use App\Policies\GrupoEconomicoPolicy;
use App\Models\Colaborador;
use App\Policies\ColaboradorPolicy;


class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
    \App\Models\GrupoEconomico::class => \App\Policies\GrupoEconomicoPolicy::class,
    \App\Models\Bandeira::class => \App\Policies\BandeiraPolicy::class,
    \App\Models\Unidade::class => \App\Policies\UnidadePolicy::class,
    \App\Models\Colaborador::class => \App\Policies\ColaboradorPolicy::class, 
    ];

    public function boot()
    {
        $this->registerPolicies();

        //
    }
    
}
