<?php

namespace App\Livewire\Grupos;


use Livewire\Component;
use App\Models\GrupoEconomico;
use Illuminate\Validation\Rule;


class GerenciarGrupos extends Component
{
    
    public $nome = ''; 
    public $editando = false;       
    public $grupoId = null;         
    public $nomeEditando = '';
    
    protected function rules()
    {
        return [
            'nome' => ['required', 'min:3', Rule::unique('grupo_economicos', 'Nome')],
            'nomeEditando' => ['required', 'min:3', Rule::unique('grupo_economicos', 'Nome')->ignore($this->grupoId, 'Id')],
        ];
    }
    protected $rules = [
        'nome' => 'required|min:3|unique:grupo_economicos,Nome',
    ];
    public function render()
    {
        $grupos = GrupoEconomico::orderBy('Nome', 'asc')->get();
        return view('livewire.grupos.gerenciar-grupos', [
            'grupos' => $grupos,
        ]);
    }
    
    public function save()
    {
        $this->authorize('create', \App\Models\GrupoEconomico::class);
        $this->validate([
            'nome' => $this->rules()['nome'],]);

        GrupoEconomico::create([
            'Nome' => $this->nome,
        ]);
        $this->reset('nome');
        session()->flash('success', 'Grupo Econômico criado com sucesso!');
    }

    public function delete(GrupoEconomico $grupo)
    {
        $this->authorize('delete', $grupo);
        if ($grupo->bandeiras()->count() > 0) {
            session()->flash('error', 'Não é possível deletar o grupo. Existem bandeiras associadas.');
            return;
        }
        $grupo->delete();
        session()->flash('success', 'Grupo Econômico deletado com sucesso!');
    }

    public function edit(GrupoEconomico $grupo)
    {
        $this->editando = true;         
        $this->grupoId = $grupo->Id;    
        $this->nomeEditando = $grupo->Nome; 
    }
    
    public function update()
    {
        $this->validate(['nomeEditando' => $this->rules()['nomeEditando']]);
        $grupo = GrupoEconomico::find($this->grupoId);

        $grupo->Nome = $this->nomeEditando;
        $grupo->save(); 

        $this->authorize('update', $grupo);

        $this->reset(['editando', 'grupoId', 'nomeEditando']);
        session()->flash('success', 'Grupo Econômico atualizado com sucesso!');
    }
    

    public function cancelEdit()
    {
        $this->reset(['editando', 'grupoId', 'nomeEditando']);
    }
}
