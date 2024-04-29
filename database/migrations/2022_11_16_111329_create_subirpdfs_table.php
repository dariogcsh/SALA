<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubirpdfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subirpdfs', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->string('ruta');
            $table->string('tipo');
            $table->string('ventastipo');
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
        Schema::dropIfExists('subirpdfs');
    }
}
