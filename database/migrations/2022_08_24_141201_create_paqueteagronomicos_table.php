<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaqueteagronomicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paqueteagronomicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_organizacion');
            $table->unsignedbigInteger('id_jdlink')->nullable();
            $table->integer('anofiscal');
            $table->enum('altimetria',['SI','NO'])->default('NO');
            $table->enum('suelo',['SI','NO'])->default('NO');
            $table->enum('compactacion',['SI','NO'])->default('NO');
            $table->date('vencimiento');
            $table->integer('hectareas');
            $table->integer('lotes');
            $table->integer('costo')->nullable();
            $table->timestamps();

            $table->foreign('id_organizacion')
                  ->references('id')
                  ->on('organizacions');

            $table->foreign('id_jdlink')
                  ->references('id')
                  ->on('jdlinks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paqueteagronomicos');
    }
}
