<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_ecoles extends Model
{
    protected $fillable=['id','nom_ecole','code_ecole','adresse_ecole','contact_ecole',
    'mail_ecole','autresdetails_ecole','author','refUser','active'];
    protected $table = 'tecole_ecoles';
}
