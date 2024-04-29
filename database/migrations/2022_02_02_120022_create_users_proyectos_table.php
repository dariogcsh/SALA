<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_proyectos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_user');
            $table->unsignedbigInteger('id_proyecto');
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id')
                  ->on('users');

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
        Schema::dropIfExists('users_proyectos');
    }
}
