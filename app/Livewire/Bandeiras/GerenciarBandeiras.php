<?php

namespace App\Livewire\Bandeiras;

use Livewire\Component;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;
use Illuminate\Validation\Rule;

class GerenciarBandeiras extends Component
{
    public $nome = ''; 
    public $grupo_economico = ''; 
    public $editando = false;
    public $bandeiraId = null;
    public $nomeEditando = '';
    public $grupoEconomicoEditando = '';

    protected function rules()
    {
        return [
            'nome' => ['required', 'min:3', Rule::unique('bandeiras', 'Nome')],
            'grupo_economico' => 'required|exists:grupo_economicos,Id', 
            'nomeEditando' => ['required', 'min:3', Rule::unique('bandeiras', 'Nome')->ignore($this->bandeiraId, 'Id')],
            'grupoEconomicoEditando' => 'required|exists:grupo_economicos,Id',
        ];
    }

    public function edit(Bandeira $bandeira)
    {
        $this->editando = true;             
        $this->bandeiraId = $bandeira->Id;  
        $this->nomeEditando = $bandeira->Nome;
        $this->grupoEconomicoEditando = $bandeira->Grupo_economico; 
    }

    public function save()
    {
        $this->validate([
            'nome' => $this->rules()['nome'],
            'grupo_economico' => $this->rules()['grupo_economico'],
        ]);
        Bandeira::create([
            'Nome' => $this->nome,
            'Grupo_economico' => $this->grupo_economico, 
        ]);
        $this->reset(['nome', 'grupo_economico']);
        session()->flash('success', 'Bandeira criada com sucesso!');
    }

    public function delete(Bandeira $bandeira)
    {
        if ($bandeira->unidades()->count() > 0) {
            session()->flash('error', 'Não é possível deletar a bandeira. Existem unidades associadas.');
            return;
        }
        $bandeira->delete();
        session()->flash('success', 'Bandeira deletada com sucesso!');
    }

    public function render()
    {
        $bandeiras = Bandeira::with('grupoEconomico') 
                              ->orderBy('Nome')->get();
        $grupos = GrupoEconomico::orderBy('Nome')->get();

        return view('livewire.bandeiras.gerenciar-bandeiras', [
            'bandeiras' => $bandeiras,
            'grupos' => $grupos, 
        ]);
    }

    public function update()
    {
        $this->validate([
            'nomeEditando' => $this->rules()['nomeEditando'],
            'grupoEconomicoEditando' => $this->rules()['grupoEconomicoEditando'],
        ]);
        $bandeira = Bandeira::find($this->bandeiraId);
        $bandeira->Nome = $this->nomeEditando;
        $bandeira->Grupo_economico = $this->grupoEconomicoEditando;
        $bandeira->save(); 
        $this->reset(['editando', 'bandeiraId', 'nomeEditando', 'grupoEconomicoEditando']);
        session()->flash('success', 'Bandeira atualizada com sucesso!');
    }

    public function cancelEdit()
    {
        $this->reset(['editando', 'bandeiraId', 'nomeEditando', 'grupoEconomicoEditando']);
    }



}