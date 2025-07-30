<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportador extends Model
{
    protected $fillable = [
        'nombre',
        'cc',
        'email'
    ];
    use HasFactory;
}
