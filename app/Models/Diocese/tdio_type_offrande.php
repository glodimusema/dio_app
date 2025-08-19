<?php

namespace App\Models\Diocese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdio_type_offrande extends Model
{
    protected $fillable=['id','nom_type_offrande','montant','author','refUser','active'];
    protected $table = 'tdio_type_offrande';
}
