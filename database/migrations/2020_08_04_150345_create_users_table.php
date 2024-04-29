<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->bigInteger('TeleUser');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('TokenNotificacion',255)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('CodiOrga')->nullable();
            $table->foreign('CodiOrga')
                  ->references('id')
                  ->on('organizacions');
            $table->unsignedBigInteger('CodiPuEm')->nullable();
            $table->foreign('CodiPuEm')
                  ->references('id')
                  ->on('puesto_empleados');
            $table->unsignedBigInteger('CodiSucu')->nullable();
            $table->foreign('CodiSucu')
                  ->references('id')
                  ->on('sucursals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
