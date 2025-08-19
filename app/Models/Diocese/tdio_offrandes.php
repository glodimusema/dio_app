<?php

namespace App\Models\Diocese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdio_offrandes extends Model
{
    protected $fillable=['id','refChretien','refTypeOffrande','refAnnee',
    'montant_offrande','date_offrande','autres_details_offrende',
    'author','refUser','active'];
    protected $table = 'tdio_offrandes';
}
