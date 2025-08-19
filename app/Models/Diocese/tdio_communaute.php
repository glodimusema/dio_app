<?php

namespace App\Models\Diocese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdio_communaute extends Model
{
    protected $fillable=['id','nom_communaute','refQuartiers','author','refUser','active'];
    protected $table = 'tdio_communaute';
}
