<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_etapa');
            $table->unsignedbigInteger('id_puesto');
            $table->string('nombre');
            $table->integer('orden');
            $table->unsignedBigInteger('id_paso_anterior')->nullable();
            $table->string('valor_condicion_anterior')->nullable();
            $table->string('condicion');
            $table->timestamps();

            $table->foreign('id_etapa')
                  ->references('id')
                  ->on('etapas');
            $table->foreign('id_puesto')
                  ->references('id')
                  ->on('puesto_empleados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasos');
    }
}
