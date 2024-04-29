<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdentrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordentrabajos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_organizacion');
            $table->unsignedbigInteger('id_lote');
            $table->unsignedbigInteger('id_usuarioorden');
            $table->unsignedbigInteger('id_usuariotrabajo');
            $table->date('fechaindicada');
            $table->date('fechainicio')->nullable();
            $table->date('fechafin')->nullable();
            $table->string('estado');
            $table->integer('has');
            $table->integer('tipo');
            $table->timestamps();

            $table->foreign('id_organizacion')
                  ->references('id')
                  ->on('organizacions');

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
        Schema::dropIfExists('ordentrabajos');
    }
}
