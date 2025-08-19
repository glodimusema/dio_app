<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTecoleEcolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tecole_ecoles', function (Blueprint $table) {
            $table->id();
            $table->string('nom_ecole',225);
            $table->string('code_ecole',225);
            $table->string('adresse_ecole',225);
            $table->string('contact_ecole',225);
            $table->string('mail_ecole',225);
            $table->string('autresdetails_ecole',225);
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
        Schema::dropIfExists('tecole_ecoles');
    }
}
