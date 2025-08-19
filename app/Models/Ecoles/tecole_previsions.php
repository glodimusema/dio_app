<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_previsions extends Model
{
    protected $fillable=['id','refClasse','refOption','refAnnee','refEcole',
    'montant_prevu','author','refUser','active'];
    protected $table = 'tecole_previsions';
}
