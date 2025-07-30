<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
      'area',
      'localicacion',
      'updated_at',
      'created_at'
    ];

    use HasFactory;
    public function reportes(){
        return $this->hasMany(Reporte::class);
    }
}
