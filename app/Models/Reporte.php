<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $fillable = [
        'area',
        'cargo_id',
        'zona',
        'ReportadoPor',
        'impactos',
        'descripcion',
        'prioridad',
        'adjunto',
        'estado',
        'orden',
        'resuesta',
        'colaborador_id',
        'responsable_id',
        'consecutivo',
        'email',
        'seguimiento',
        'areaTrabajo'
    ];

    use HasFactory;

    public function area()  {
        return  $this->belongsTo(Area::class);
    }

    public function cargo(){
        return $this->belongsTo(Cargo::class);
    }

    public function comentarios(){
        return $this->belongsToMany(Comentario::class);
    }

    public function impactos(){
        return $this->belongsToMany(Impacto::class);
    }

    public function gestion(){
        return $this->belongsTo(Gestion::class);
    }
}
