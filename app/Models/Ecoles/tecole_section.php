<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_type_frais extends Model
{
    protected $fillable=['id','nom_type_frais','code_type_frais','author','refUser','active'];
    protected $table = 'tecole_type_frais';
}
