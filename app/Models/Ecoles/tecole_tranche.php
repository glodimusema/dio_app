<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_tranche extends Model
{
    protected $fillable=['id','nom_tranche','code_tranche','author','refUser','active'];
    protected $table = 'tecole_tranche';
}
