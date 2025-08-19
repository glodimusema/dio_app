<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_type_annee extends Model
{
    protected $fillable=['id','nom_annee','code_annee','author','refUser','active'];
    protected $table = 'tecole_type_annee';
}
