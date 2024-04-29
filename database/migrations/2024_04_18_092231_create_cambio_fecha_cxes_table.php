<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCambioFechaCxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cambio_fecha_cxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_reclamo');
            $table->string('accion');
            $table->date('fecha_vieja');
            $table->date('fecha_nueva');
            $table->timestamps();

            $table->foreign('id_reclamo')
                  ->references('id')
                  ->on('reclamos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cambio_fecha_cxes');
    }
}
