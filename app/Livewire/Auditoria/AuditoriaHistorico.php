<?php

namespace App\Livewire\Auditoria;

use Livewire\Component;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;

class AuditoriaHistorico extends Component
{
    use WithPagination;
    public $filterModel = ''; 
    public $filterEvent = '';
    public $filterUser = '';  
    
    public $models = [
        'Grupo Econômico' => 'App\Models\GrupoEconomico',
        'Bandeira' => 'App\Models\Bandeira',
        'Unidade' => 'App\Models\Unidade',
        'Colaborador' => 'App\Models\Colaborador',
    ];

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterModel', 'filterEvent', 'filterUser'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = Audit::query()
            ->with('user'); 

        if ($this->filterModel) {
            $query->where('auditable_type', $this->filterModel);
        }

        if ($this->filterEvent) {
            $query->where('event', $this->filterEvent);
        }
        $auditorias = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('livewire.auditoria.auditoria-historico', [
            'auditorias' => $auditorias, 
        ]);
    }
}