<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_user');
            $table->unsignedbigInteger('id_organizacion');
            $table->string('persona',255);
            $table->string('tipo',255);
            $table->string('departamento',255);
            $table->string('comentarios',1000)->nullable();
            $table->timestamps();

            $table->foreign('id_organizacion')
                  ->references('id')
                  ->on('organizacions');

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
        Schema::dropIfExists('contactos');
    }
}
