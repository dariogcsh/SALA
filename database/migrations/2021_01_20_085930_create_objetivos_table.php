<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_tipoobjetivo');
            $table->unsignedbigInteger('id_maquina');
            $table->decimal('objetivo', 10, 2);
            $table->string('cultivo');
            $table->integer('ano');
            $table->enum('establecido',['Cliente','App']);
            $table->timestamps();

            $table->foreign('id_tipoobjetivo')
                  ->references('id')
                  ->on('tipoobjetivos');

            $table->foreign('id_maquina')
                  ->references('id')
                  ->on('maquinas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objetivos');
    }
}
