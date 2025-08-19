<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_classe extends Model
{
    protected $fillable=['id','nom_classe','code_classe','author','refUser','active'];
    protected $table = 'tecole_classe';
}
