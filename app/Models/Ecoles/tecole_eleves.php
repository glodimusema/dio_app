<?php

namespace App\Models\Ecoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecole_eleves extends Model
{
    protected $fillable=['id','matricule_eleve','noms_eleve','sexe_eleve','datenaissance_eleve',
    'lieunaissnce_eleve','provinceOrigine_eleve','etatcivil_eleve','refAvenue_eleve','nummaison_eleve',
    'contact1_eleve','contact2_eleve','mail_eleve','nomPere_eleve','nomMere_eleve','Nationalite_eleve',
    'Collectivite_eleve','Territoire_eleve','EmployeurAnt_eleve','PersRef_eleve','photo','slug','cartes',
    'envie','author','refUser','active','deleted','author_deleted'];
    protected $table = 'tecole_eleves';
}
