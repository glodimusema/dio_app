<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdio_carre extends Model
{
    protected $fillable=['id','nom_carre','refCommunaute',
    'author','refUser','active'];
    protected $table = 'tdio_carre';
}
