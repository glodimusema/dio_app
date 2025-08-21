<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdioTypeOffrandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdio_type_offrande', function (Blueprint $table) {
            $table->id();
            $table->string('nom_type_offrande',225);
            $table->double('montant')->default(0);
            $table->string('devise',50);
            $table->double('taux');
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
        Schema::dropIfExists('tdio_type_offrande');
    }
}
