<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaqueteMaquinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquete_maquinas', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_paquete');
            $table->timestamps();

            $table->foreign('id_paquete')
                  ->references('id')
                  ->on('paqueteagronomicos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paquete_maquinas');
    }
}
