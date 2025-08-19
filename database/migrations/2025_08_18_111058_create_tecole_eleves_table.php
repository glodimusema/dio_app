<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTecoleElevesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tecole_eleves', function (Blueprint $table) {
            $table->id();
            $table->string('matricule_eleve');
            $table->string('noms_eleve');
            $table->string('sexe_eleve'); 
            $table->string('datenaissance_eleve'); 
            $table->string('lieunaissnce_eleve');
            $table->string('provinceOrigine_eleve');           
            $table->string('etatcivil_eleve');
            $table->foreignId('refAvenue_eleve')->constrained('avenues')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nummaison_eleve');
            $table->string('contact1_eleve');
            $table->string('contact2_eleve'); 
            $table->string('mail_eleve');
            $table->string('nomPere_eleve');
            $table->string('nomMere_eleve');
            $table->string('Nationalite_eleve');
            $table->string('Collectivite_eleve');
            $table->string('Territoire_eleve');
            $table->string('EmployeurAnt_eleve');
            $table->string('PersRef_eleve');            
            $table->string('photo'); 
            $table->string('slug'); 
            $table->string('cartes')->default('NON');
            $table->string('envie')->default('OUI');            
            $table->string('author',100);
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();           
            $table->string('active')->default('OUI');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tecole_eleves');
    }
}
