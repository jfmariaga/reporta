<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = ['reporte_id', 'comentario','user_id'];

    public function reporte(){
        return $this->belongsTo(Reporte::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
