<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_evento');
            $table->unsignedbigInteger('id_sucursal')->nullable();
            $table->unsignedbigInteger('id_user');
            $table->string('ubicacion')->nullable();
            $table->date('fechainicio');
            $table->date('fechafin');
            $table->time('horainicio')->nullable();
            $table->time('horafin')->nullable();
            $table->string('titulo');
            $table->string('descripcion')->nullable();
            $table->string('externos')->nullable();
            $table->string('movilidad')->nullable();
            $table->string('reserva')->nullable();
            $table->timestamps();

            $table->foreign('id_evento')
                  ->references('id')
                  ->on('eventos');
            $table->foreign('id_sucursal')
                  ->references('id')
                  ->on('sucursals');       
            $table->foreign('id_user')
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
        Schema::dropIfExists('calendarios');
    }
}
