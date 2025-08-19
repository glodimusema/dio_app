<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdioOffrandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdio_offrandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refChretien')->constrained('tdio_chretien')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypeOffrande')->constrained('tdio_type_offrande')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refAnnee')->constrained('tperso_annee')->restrictOnUpdate()->restrictOnDelete();
            $table->double('montant_offrande');
            $table->date('date_offrande');
            $table->string('autres_details_offrende',225);
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
        Schema::dropIfExists('tdio_offrandes');
    }
}
