<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->string('descripcion');
            $table->string('pin');
            $table->string('accion')->nullable();
            $table->unsignedbigInteger('id_useraccion')->nullable();
            $table->enum('notificado',['Accion','Recomendacion'])->nullable();
            $table->integer('presupuesto')->nullable();
            $table->integer('cor')->nullable();
            $table->enum('notificado',['SI','NO'])->default('NO');
            $table->timestamps();

            $table->foreign('id_useraccion')
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
        Schema::dropIfExists('alertas');
    }
}
