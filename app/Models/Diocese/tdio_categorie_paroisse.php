<?php

namespace App\Models\Diocese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdio_categorie_paroisse extends Model
{
    protected $fillable=['id','nom_categorie_paroisse','code_categorie_paroisse',
    'author','refUser','active'];
    protected $table = 'tdio_categorie_paroisse';
}
