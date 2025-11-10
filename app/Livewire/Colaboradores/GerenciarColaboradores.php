<?php

namespace App\Livewire\Colaboradores;

use Livewire\Component;
use App\Models\Colaborador;
use App\Models\Unidade;
use Illuminate\Validation\Rule;
use App\Rules\CpfValidationRule; 


class GerenciarColaboradores extends Component
{
    public $nome = '';
    public $email = '';
    public $cpf = '';
    public $unidade_id = '';    
    public $editando = false;
    public $colaboradorId = null;
    public $nomeEditando = '';
    public $emailEditando = '';
    public $cpfEditando = '';
    public $unidadeIdEditando = '';


    protected $messages = [
        'email.unique' => 'Este e-mail já está registrado.',
        'cpf.unique' => 'Este CPF já está registrado.',
    ];
    

    protected function rules()
    {
        return [
            'nome' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('colaboradores', 'Email')],
            'cpf' => ['required', 'max:11', new CpfValidationRule(), Rule::unique('colaboradores', 'Cpf')], 
            'unidade_id' => 'required|exists:unidades,Id',
            'nomeEditando' => ['required', 'min:3'],
            'emailEditando' => ['required', 'email', Rule::unique('colaboradores', 'Email')->ignore($this->colaboradorId, 'Id')],
            'cpfEditando' => ['required', 'max:11', new CpfValidationRule(), Rule::unique('colaboradores', 'Cpf')->ignore($this->colaboradorId, 'Id')],
            'unidadeIdEditando' => 'required|exists:unidades,Id',
        ];
    }
    
    public function delete(Colaborador $colaborador)
    {
        $this->authorize('delete', $colaborador);
        $colaborador->delete();
        session()->flash('success', 'Colaborador deletado com sucesso!');
    }

    public function render()
    {
        $colaboradores = Colaborador::with('unidade')->orderBy('Nome')->get();

        $unidades = Unidade::orderBy('Nome')->get();

        return view('livewire.colaboradores.gerenciar-colaboradores', [
            'colaboradores' => $colaboradores,
            'unidades' => $unidades, 
        ]);
    }
    
    public function save()
    {
        $this->authorize('create', \App\Models\Colaborador::class);
        $this->validate([
            'nome' => $this->rules()['nome'],
            'email' => $this->rules()['email'],
            'cpf' => $this->rules()['cpf'],
            'unidade_id' => $this->rules()['unidade_id'],
        ]);

        Colaborador::create([
            'Nome' => $this->nome,
            'Email' => $this->email,
            'Cpf' => $this->cpf,
            'Unidade' => $this->unidade_id, 
        ]);

        $this->reset(['nome', 'email', 'cpf', 'unidade_id']);
        session()->flash('success', 'Colaborador criado com sucesso!');
    }

    public function edit(Colaborador $colaborador)
    {
        $this->editando = true;                
        $this->colaboradorId = $colaborador->Id;        
        $this->nomeEditando = $colaborador->Nome;
        $this->emailEditando = $colaborador->Email;
        $this->cpfEditando = $colaborador->Cpf;
        $this->unidadeIdEditando = $colaborador->Unidade; 
    }

  
    public function update()
    {
        $colaborador = Colaborador::find($this->colaboradorId);
        $this->authorize('update', $colaborador);
        $this->validate([
            'nomeEditando' => $this->rules()['nomeEditando'],
            'emailEditando' => $this->rules()['emailEditando'],
            'cpfEditando' => $this->rules()['cpfEditando'],
            'unidadeIdEditando' => $this->rules()['unidadeIdEditando'],
        ]);

        $colaborador = Colaborador::find($this->colaboradorId);
    
        $colaborador->Nome = $this->nomeEditando;
        $colaborador->Email = $this->emailEditando;
        $colaborador->Cpf = $this->cpfEditando;
        $colaborador->Unidade = $this->unidadeIdEditando; 
        $colaborador->save(); 

        $this->reset(['editando', 'colaboradorId', 'nomeEditando', 'emailEditando', 'cpfEditando', 'unidadeIdEditando']);
        session()->flash('success', 'Colaborador atualizado com sucesso!');
    }
   
    public function cancelEdit()
    {
        $this->reset(['editando', 'colaboradorId', 'nomeEditando', 'emailEditando', 'cpfEditando', 'unidadeIdEditando']);
    }

}