<?php

namespace App\Livewire\Relatorios;

use Livewire\Component;
use Livewire\WithPagination; 
use App\Models\Colaborador;
use App\Models\Unidade;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;
use App\Exports\ColaboradoresExport; 
use Maatwebsite\Excel\Facades\Excel;

class ColaboradoresReport extends Component
{
    use WithPagination;

    public $filterNome = '';
    public $filterEmail = '';
    public $filterUnidadeId = '';
    public $filterBandeiraId = '';
    public $filterGrupoId = '';

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterNome', 'filterEmail', 'filterUnidadeId', 'filterBandeiraId', 'filterGrupoId'])) {
            $this->resetPage();
        }
    }


    public function exportExcel()
    {
        $filters = [
            'filterNome' => $this->filterNome,
            'filterEmail' => $this->filterEmail,
            'filterUnidadeId' => $this->filterUnidadeId,
            'filterBandeiraId' => $this->filterBandeiraId,
            'filterGrupoId' => $this->filterGrupoId,
        ];
        try {
            return Excel::download(
                new ColaboradoresExport($filters), 
                'relatorio-colaboradores-' . now()->format('YmdHis') . '.xlsx'
            );
            session()->flash('success', 'Relatório de Colaboradores (com filtros aplicados) exportado com sucesso para Excel!');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro na exportação: ' . $e->getMessage());
        }
    }
    public function render()
    {
        $query = Colaborador::query()

            ->with(['unidade.bandeira.grupoEconomico']);

        if ($this->filterNome) {
            $query->where('Nome', 'like', '%' . $this->filterNome . '%');
        }
        
  
        if ($this->filterUnidadeId) {
            $query->where('Unidade', $this->filterUnidadeId);
        }

        if ($this->filterBandeiraId) {
            $query->whereHas('unidade.bandeira', function ($q) {
                $q->where('bandeiras.Id', $this->filterBandeiraId);
            });
        }
        
        if ($this->filterGrupoId) {
            $query->whereHas('unidade.bandeira.grupoEconomico', function ($q) {
                $q->where('grupo_economicos.Id', $this->filterGrupoId);
            });
        }
        
        $colaboradores = $query->orderBy('Nome')->paginate(20);
        $unidades = Unidade::orderBy('Nome')->get();
        $bandeiras = Bandeira::orderBy('Nome')->get();
        $grupos = GrupoEconomico::orderBy('Nome')->get();

        return view('livewire.relatorios.colaboradores-report', [
            'colaboradores' => $colaboradores,
            'unidades' => $unidades,
            'bandeiras' => $bandeiras,
            'grupos' => $grupos,
        ]);
    }
}