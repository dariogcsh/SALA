<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaquetemantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquetemants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tipo_paquete_mant');
            $table->string('descripcion',500);
            $table->integer('horas');
            $table->unsignedBigInteger('id_repuesto');
            $table->timestamps();

            $table->foreign('id_repuesto')
                  ->references('id')
                  ->on('repuestos');

            $table->foreign('id_tipo_paquete_mant')
                  ->references('id')
                  ->on('tipo_paquete_mants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paquetemants');
    }
}
