<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_organizacion')->nullable();
            $table->unsignedbigInteger('id_sucursal');
            $table->string('tipo');
            $table->string('marca');
            $table->string('modelo');
            $table->string('pin');
            $table->string('detalle',9500)->nullable();
            $table->timestamps();

            $table->foreign('id_organizacion')
                  ->references('id')
                  ->on('organizacions');
            $table->foreign('id_sucursal')
                  ->references('id')
                  ->on('sucursals');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entregas');
    }
}
