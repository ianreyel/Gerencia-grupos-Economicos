<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\grupoEconomico;
use OwenIt\Auditing\Contracts\Auditable;

class Bandeira extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable; 
    protected $primaryKey = 'Id';
    const CREATED_AT = 'Data_criacao';
    const UPDATED_AT = 'Ultima_atualizacao';
    protected $fillable = ['Nome', 'Grupo_economico'];

    protected $auditable = [
        'Nome',
        'Grupo_economico',
    ];

    public function grupoEconomico()
    {
        return $this->belongsTo(GrupoEconomico::class, 
                'Grupo_economico',  
                'Id');             
    }
    public function unidades()
    {
        return $this->hasMany(Unidade::class, 
                              'Bandeira', 
                              'Id');      
    }
}
