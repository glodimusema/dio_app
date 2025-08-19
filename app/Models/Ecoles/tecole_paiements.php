<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_paiements extends Model
{
    protected $fillable=['id','RefInscription','refBanque','montant_paie','devise',
    'taux','date_paie','modepaie','libellepaie','numeroBordereau','author','refUser',
    'active'];
    protected $table = 'tecole_paiements';
}
