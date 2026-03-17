<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoApoyo extends Model
{
    protected $fillable = [
        'responsable_id',
        'apoyo_id',
        'activo'
    ];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function apoyo()
    {
        return $this->belongsTo(User::class, 'apoyo_id');
    }
}
