<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_mezclainsu');
            $table->unsignedbigInteger('id_lote');
            $table->unsignedbigInteger('id_usuarioorden');
            $table->unsignedbigInteger('id_usuariotrabajo');
            $table->string('estado');
            $table->date('fechaorden');
            $table->date('fechafin')->nullable();
            $table->timestamps();

            $table->foreign('id_mezclainsu')
                  ->references('id')
                  ->on('mezcla_insus');

            $table->foreign('id_lote')
                  ->references('id')
                  ->on('lotes');

            $table->foreign('id_usuarioorden')
                  ->references('id')
                  ->on('users');

            $table->foreign('id_usuariotrabajo')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajos');
    }
}
