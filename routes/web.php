<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Grupos\GerenciarGrupos;
use App\Livewire\Unidades\GerenciarUnidades;
use App\Livewire\bandeiras\GerenciarBandeiras;
use App\Livewire\Colaboradores\GerenciarColaboradores;
use App\Livewire\Relatorios\ColaboradoresReport;
use App\Livewire\Auditoria\AuditoriaHistorico; 


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::middleware(['auth'])->group(function () {
    Route::get('/unidades', GerenciarUnidades::class)->name('unidades.index');
    Route::get('/bandeiras', GerenciarBandeiras::class)->name('bandeiras.index');
    Route::get('/grupos', GerenciarGrupos::class)->name('grupos.index');
    Route::get('/colaboradores', GerenciarColaboradores::class)->name('colaboradores.index');
    Route::get('/relatorio/colaboradores', ColaboradoresReport::class)->name('relatorios.colaboradores');
    Route::get('/auditoria/historico', AuditoriaHistorico::class)->name('auditoria.historico');
});

require __DIR__.'/auth.php';
