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
            $table->date('nacimiento');
            $table->string('TokenNotificacion',255)->nullable();
            $table->unsignedBigInteger('CodiOrga')->nullable();
            $table->unsignedBigInteger('CodiPuEm')->nullable();
            $table->unsignedBigInteger('CodiSucu')->nullable();
            $table->timestamps();

            
            $table->foreign('CodiOrga')
                  ->references('id')
                  ->on('organizacions');
            
            $table->foreign('CodiPuEm')
                  ->references('id')
                  ->on('puesto_empleados');
            
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
