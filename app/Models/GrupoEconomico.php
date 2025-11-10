<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bandeira;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class GrupoEconomico extends Model implements Auditable 
{
    use HasFactory, \OwenIt\Auditing\Auditable; 
    protected $primaryKey = 'Id';
    const CREATED_AT = 'Data_criacao';
    const UPDATED_AT = 'Ultima_atualizacao';
    protected $fillable = ['Nome'];

    public function bandeiras()
    {
        return $this->hasMany(Bandeira::class, 
                              'Grupo_economico', 
                              'Id');             
    }
     protected $auditable = [
        'Nome',
    ];
    protected $dontKeepAudit = [];
}

