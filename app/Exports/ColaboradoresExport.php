<?php

namespace App\Exports;

use App\Models\Colaborador;
use Maatwebsite\Excel\Concerns\FromCollection; 
use Maatwebsite\Excel\Concerns\WithHeadings;   
use Illuminate\Support\Collection;


class ColaboradoresExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

  
    public function collection()
    {

        $query = Colaborador::query()
            ->with(['unidade.bandeira.grupoEconomico']);

        if ($this->filters['filterNome']) {
            $query->where('Nome', 'like', '%' . $this->filters['filterNome'] . '%');
        }
        
        if ($this->filters['filterUnidadeId']) {
            $query->where('Unidade', $this->filters['filterUnidadeId']);
        }

        if ($this->filters['filterBandeiraId']) {
            $query->whereHas('unidade.bandeira', function ($q) {
                $q->where('bandeiras.Id', $this->filters['filterBandeiraId']);
            });
        }
        
        if ($this->filters['filterGrupoId']) {
            $query->whereHas('unidade.bandeira.grupoEconomico', function ($q) {
                $q->where('grupo_economicos.Id', $this->filters['filterGrupoId']);
            });
        }
        

        $colaboradores = $query->orderBy('Nome')->get();
        return $colaboradores->map(function ($colaborador) {
            return [
                'ID' => $colaborador->Id,
                'Nome Colaborador' => $colaborador->Nome,
                'Email' => $colaborador->Email,
                'CPF' => $colaborador->Cpf,
                'Unidade' => $colaborador->unidade->Nome ?? 'N/A',
                'Bandeira' => $colaborador->unidade->bandeira->Nome ?? 'N/A',
                'Grupo Econômico' => $colaborador->unidade->bandeira->grupoEconomico->Nome ?? 'N/A',
                'Data Criacao' => $colaborador->Data_criacao,
            ];
        });
    }

 
    public function headings(): array
    {
        return [
            'ID',
            'Nome Colaborador',
            'Email',
            'CPF',
            'Unidade',
            'Bandeira',
            'Grupo Econômico',
            'Data Criação',
        ];
    }
}