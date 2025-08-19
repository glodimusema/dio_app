<?php

namespace App\Models\Diocese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdio_responsable_paroisse extends Model
{
    protected $fillable=['id','refParoisse','refResponsable','autres_details_respo',
    'date_debut_responsable','dure_reponsable','date_fin_responsable','author',
    'refUser','active'];
    protected $table = 'tdio_responsable_paroisse';
}
