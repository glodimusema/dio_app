<?php

namespace App\Models\Diocese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdio_type_sacrement extends Model
{
    protected $fillable=['id','nom_type_sacrement','code_type_sacrement',
    'qualification_type_sacrement','author','refUser','active'];
    protected $table = 'tdio_type_sacrement';
}
