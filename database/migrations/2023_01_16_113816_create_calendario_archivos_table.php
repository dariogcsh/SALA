<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarioArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendario_archivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_calendario');
            $table->string('path');
            $table->timestamps();

            $table->foreign('id_calendario')
                  ->references('id')
                  ->on('calendarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendario_archivos');
    }
}
