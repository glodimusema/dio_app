<?php

namespace App\Models\Diocese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdio_quartier extends Model
{
    protected $fillable=['id','nom_quartier_dio','refParoisse',
    'author','refUser','active'];
    protected $table = 'tdio_quartier';
}
