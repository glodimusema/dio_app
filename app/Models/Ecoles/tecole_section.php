<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_section extends Model
{
    protected $fillable=['id','nom_section','code_section','author','refUser','active'];
    protected $table = 'tecole_section';
}
