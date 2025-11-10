<?php

namespace App\Livewire\Unidades;

use Livewire\Component;
use App\Models\Unidade;
use App\Models\Bandeira;
use Illuminate\Validation\Rule;
use App\Rules\CnpjValidationRule;

class GerenciarUnidades extends Component 
{
    public $nome = '';           
    public $razao_social = '';
    public $cnpj = '';
    public $bandeira_id = '';    
    public $editando = false;
    public $unidadeId = null;
    public $nomeEditando = '';
    public $razaoSocialEditando = '';
    public $cnpjEditando = '';
    public $bandeiraIdEditando = '';


    protected $messages = [
        'cnpj.unique' => 'Este CNPJ já está registrado em outra unidade.',
        'cnpj.required' => 'O campo CNPJ é obrigatório.',
        'razao_social.unique' => 'Esta Razão Social já está registrada.',
    ];
    
    protected function rules()
    {
        return [
            'nome' => ['required', 'min:3'],
            'razao_social' => ['required', 'min:5', Rule::unique('unidades', 'Razao_social')],
            'cnpj' => ['required', 'max:14', new CnpjValidationRule(), Rule::unique('unidades', 'Cnpj')], 
            'bandeira_id' => 'required|exists:bandeiras,Id',
            'nomeEditando' => ['required', 'min:3'],
            'razaoSocialEditando' => ['required', 'min:5', Rule::unique('unidades', 'Razao_social')->ignore($this->unidadeId, 'Id')],
            'cnpjEditando' => ['required', 'max:14', new CnpjValidationRule(), Rule::unique('unidades', 'Cnpj')->ignore($this->unidadeId, 'Id')],
            'bandeiraIdEditando' => 'required|exists:bandeiras,Id',
        ];
    }
    

    public function delete(Unidade $unidade)
    {
        if ($unidade->colaboradores()->count() > 0) {
            session()->flash('error', 'Não é possível deletar a unidade. Existem colaboradores associados.');
            return;
        }
        $unidade->delete();
        session()->flash('success', 'Unidade deletada com sucesso!');
    }

    public function render()
    {
        $unidades = Unidade::with('bandeira')->orderBy('Nome')->get();
        $bandeiras = Bandeira::orderBy('Nome')->get();

        return view('livewire.unidades.gerenciar-unidades', [
            'unidades' => $unidades,
            'bandeiras' => $bandeiras, 
        ]);
    }
    
    public function save()
    {
        $this->validate([
            'nome' => $this->rules()['nome'],
            'razao_social' => $this->rules()['razao_social'],
            'cnpj' => $this->rules()['cnpj'],
            'bandeira_id' => $this->rules()['bandeira_id'],
        ]);

        Unidade::create([
            'Nome' => $this->nome,
            'Razao_social' => $this->razao_social,
            'Cnpj' => $this->cnpj,
            'Bandeira' => $this->bandeira_id,
        ]);

        $this->reset(['nome', 'razao_social', 'cnpj', 'bandeira_id']);
        session()->flash('success', 'Unidade criada com sucesso!');
    }

    public function edit(Unidade $unidade)
    {
        $this->editando = true;                 
        $this->unidadeId = $unidade->Id;        
        $this->nomeEditando = $unidade->Nome;
        $this->razaoSocialEditando = $unidade->Razao_social;
        $this->cnpjEditando = $unidade->Cnpj;
        $this->bandeiraIdEditando = $unidade->Bandeira; 
    }

    public function update()
    {
        $this->validate([
            'nomeEditando' => $this->rules()['nomeEditando'],
            'razaoSocialEditando' => $this->rules()['razaoSocialEditando'],
            'cnpjEditando' => $this->rules()['cnpjEditando'],
            'bandeiraIdEditando' => $this->rules()['bandeiraIdEditando'],
        ]);

   
        $unidade = Unidade::find($this->unidadeId);
        $unidade->Nome = $this->nomeEditando;
        $unidade->Razao_social = $this->razaoSocialEditando;
        $unidade->Cnpj = $this->cnpjEditando;
        $unidade->Bandeira = $this->bandeiraIdEditando; 
        $unidade->save(); 

   
        $this->reset(['editando', 'unidadeId', 'nomeEditando', 'razaoSocialEditando', 'cnpjEditando', 'bandeiraIdEditando']);
        session()->flash('success', 'Unidade atualizada com sucesso!');
    }
    
    public function cancelEdit()
    {
        $this->reset(['editando', 'unidadeId', 'nomeEditando', 'razaoSocialEditando', 'cnpjEditando', 'bandeiraIdEditando']);
    }


}