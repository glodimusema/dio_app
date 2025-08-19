<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_inscriptions extends Model
{
    protected $fillable=['id','refEleve','refClasse','refOption','refDivision','refAnnee'
    ,'refEcole','montant_prevu','montant_paie','autres_details_inscription','author','refUser','active'];
    protected $table = 'tecole_inscriptions';
}
