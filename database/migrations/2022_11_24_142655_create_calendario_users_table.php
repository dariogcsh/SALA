<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarioUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendario_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_calendario');
            $table->unsignedbigInteger('id_user');
            $table->string('tipo');
            $table->string('estado');
            $table->timestamps();

            $table->foreign('id_calendario')
                  ->references('id')
                  ->on('calendarios');

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
        Schema::dropIfExists('calendario_users');
    }
}
