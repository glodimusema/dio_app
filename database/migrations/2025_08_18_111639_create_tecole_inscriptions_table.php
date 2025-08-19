<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTecoleInscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tecole_inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEleve')->constrained('tecole_eleves')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refClasse')->constrained('tecole_classe')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refOption')->constrained('tecole_option')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refDivision')->constrained('tecole_type_division')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refAnnee')->constrained('tecole_type_annee')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refEcole')->constrained('tecole_ecoles')->restrictOnUpdate()->restrictOnDelete();
            $table->double('montant_prevu')->default(0);
            $table->double('montant_paie')->default(0);
            $table->string('autres_details_inscription',225);
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
        Schema::dropIfExists('tecole_inscriptions');
    }
}
