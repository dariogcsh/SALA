<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solucions', function (Blueprint $table) {
            $table->id();
            $table->string('DescSolu');
            $table->string('tipo')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_asist');
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id')
                  ->on('users');

            $table->foreign('id_asist')
                  ->references('id')
                  ->on('asists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solucions');
    }
}
