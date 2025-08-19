<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_type_division extends Model
{
    protected $fillable=['id','nom_division','code_division','author','refUser','active'];
    protected $table = 'tecole_type_division';
}
