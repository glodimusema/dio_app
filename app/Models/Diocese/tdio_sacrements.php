<?php

namespace App\Models\Diocese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdio_sacrements extends Model
{
    protected $fillable=['id','refChretien','refTypeSacrement','refCommunaute',
    'refPretre','refCure','date_sacrement','temoin1','temoin2',
    'autres_details_offrende','refConjoint','author','refUser','active'];
    protected $table = 'tdio_sacrements';
}
