<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanserviciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planservicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_tarea');
            $table->unsignedbigInteger('id_user');
            $table->date('fechaplan');
            $table->string('turno')->nullable();
            $table->timestamps();

            $table->foreign('id_tarea')
                  ->references('id')
                  ->on('tareas');

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
        Schema::dropIfExists('planservicios');
    }
}
