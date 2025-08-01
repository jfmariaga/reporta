<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;
    protected $fillable = ['area','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reportes(){
        return $this->hasMany(Reporte::class);
    }

    
}
