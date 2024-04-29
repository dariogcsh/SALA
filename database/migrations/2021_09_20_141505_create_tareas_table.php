<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_organizacion');
            $table->integer('ncor')->nullable();
            $table->string('descripcion');
            $table->string('nseriemaq')->nullable();
            $table->string('ubicacion');
            $table->string('estado');
            $table->string('prioridad')->nullable();
            $table->decimal('importe', 10,2)->nullable();
            $table->timestamps();

            $table->foreign('id_organizacion')
                  ->references('id')
                  ->on('organizacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tareas');
    }
}
