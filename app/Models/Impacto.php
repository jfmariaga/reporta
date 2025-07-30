<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impacto extends Model
{
    protected $fillable = [
        'impacto',
        'user_id',
        'updated_at',
        'created_at'
      ];
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reportes(){
        return $this->hasMany(Reporte::class);
    }
}
