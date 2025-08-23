<?php

namespace App\Models\Diocese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdio_chretien extends Model
{
    protected $fillable=['id','noms_chretien','sexe_chretien','etatcivil_chretien',
    'adresse_chretien','contact1_chretien','contact2_chretien','mail_chretien',
    'nom_pere_chretien','nom_mere_chretien','lieunaissance_chretien','datenaissance_chretien',
    'code_secret','photo','refCommunaute','date_sacrement','statut_sacrement','author',
    'refUser','active'];
    protected $table = 'tdio_chretien';
}
