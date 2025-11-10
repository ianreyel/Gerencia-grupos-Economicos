<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unidade;
use OwenIt\Auditing\Contracts\Auditable;

class Colaborador extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable; 
    protected $table = 'colaboradores';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'Data_criacao';
    const UPDATED_AT = 'Ultima_atualizacao';
     
    protected $fillable = [
        'Nome',
        'Email',       
        'Cpf',
        'Unidade'      
    ];

    protected $auditable = [
        'Nome',
        'Email',
        'Cpf',
        'Unidade',
    ];
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 
                                'Unidade',
                                'Id');     
    }
}
