<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_organizacion');
            $table->unsignedbigInteger('id_servicioscsc');
            $table->unsignedbigInteger('id_proyecto');
            $table->string('nombreservicio')->nullable();
            $table->integer('minutos_acumulados');
            $table->string('estado')->nullable();
            $table->timestamps();

            $table->foreign('id_organizacion')
                  ->references('id')
                  ->on('organizacions');

            $table->foreign('id_servicioscsc')
                  ->references('id')
                  ->on('servicioscscs');
            $table->foreign('id_proyecto')
                  ->references('id')
                  ->on('proyectos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
