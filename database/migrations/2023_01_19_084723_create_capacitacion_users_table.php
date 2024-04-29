<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapacitacionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capacitacion_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_capacitacion');
            $table->unsignedbigInteger('id_user');
            $table->string('tipo');
            $table->string('estado');
            $table->timestamps();

            $table->foreign('id_capacitacion')
                  ->references('id')
                  ->on('capacitacions');

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
        Schema::dropIfExists('capacitacion_users');
    }
}
