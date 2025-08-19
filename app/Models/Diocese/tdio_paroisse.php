<?php

namespace App\Models\Diocese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdio_paroisse extends Model
{
    protected $fillable=['id','nom_paroisse','code_paroisse','description_paroisse',
    'autres_details_paroisse','refCatParoisse','author','refUser','active'];
    protected $table = 'tdio_paroisse';
}
