<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_option extends Model
{
    protected $fillable=['id','nom_option','code_option','refSection',
    'author','refUser','active'];
    protected $table = 'tecole_option';
}
