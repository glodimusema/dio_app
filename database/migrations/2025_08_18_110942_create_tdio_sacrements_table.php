<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdioSacrementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdio_sacrements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refChretien')->constrained('tdio_chretien')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypeSacrement')->constrained('tdio_type_sacrement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refCommunaute')->constrained('tdio_communaute')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refPretre')->constrained('tagent')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refCure')->constrained('tagent')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_sacrement');
            $table->string('temoin1',225);
            $table->string('temoin2',225);
            $table->string('autres_details_offrende',225);
            $table->foreignId('refConjoint')->constrained('tdio_chretien')->restrictOnUpdate()->restrictOnDelete()->default(0);
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
        Schema::dropIfExists('tdio_sacrements');
    }
}
