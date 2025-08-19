<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdioResponsableParoisseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdio_responsable_paroisse', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refParoisse')->constrained('tdio_paroisse')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refResponsable')->constrained('tagent')->restrictOnUpdate()->restrictOnDelete();
            $table->string('autres_details_respo',225);
            $table->date('date_debut_responsable');
            $table->double('dure_reponsable');
            $table->date('date_fin_responsable')->default(null);  
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
        Schema::dropIfExists('tdio_responsable_paroisse');
    }
}
