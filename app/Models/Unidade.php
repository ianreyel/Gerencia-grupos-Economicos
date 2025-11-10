<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bandeira;   
use App\Models\Colaborador; 
use OwenIt\Auditing\Contracts\Auditable;

class Unidade extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable; 
    protected $primaryKey = 'Id';
    const CREATED_AT = 'Data_criacao';
    const UPDATED_AT = 'Ultima_atualizacao';
    protected $fillable = [
        'Nome',          
        'Razao_social',  
        'Cnpj',
        'Bandeira'       
    ];

    protected $auditable = [
        'Nome',
        'Razao_social',
        'Cnpj',
        'Bandeira', 
    ];
    
    public function bandeira()
    {
        return $this->belongsTo(Bandeira::class, 'Bandeira', 'Id');
    }
    public function colaboradores()
    {
        return $this->hasMany(Colaborador::class, 'Unidade', 'Id');
    }
}