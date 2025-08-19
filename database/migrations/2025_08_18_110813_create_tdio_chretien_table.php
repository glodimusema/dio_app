<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdioChretienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdio_chretien', function (Blueprint $table) {
            $table->id();
            $table->string('noms_chretien',225);
            $table->string('adresse_chretien',225);
            $table->string('contact1_chretien',15);
            $table->string('contact2_chretien',15);
            $table->string('mail_chretien',225);
            $table->string('nom_pere_chretien',225);
            $table->string('nom_mere_chretien',225);
            $table->string('lieunaissance_chretien',225);
            $table->date('datenaissance_chretien');  
            $table->string('photo');           
            $table->foreignId('refCommunaute')->constrained('tdio_communaute')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_sacrement');
            $table->string('statut_sacrement',20)->default('Baptisé');
            $table->string('author',100);
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();           
            $table->string('active')->default('OUI');
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
        Schema::dropIfExists('tdio_chretien');
    }
}
