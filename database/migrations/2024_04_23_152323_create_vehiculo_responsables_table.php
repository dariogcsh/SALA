<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Ramsey\Uuid\v1;

class CreateVehiculoResponsablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo_responsables', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_user');
            $table->unsignedbigInteger('id_vehiculo');
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id')
                  ->on('users');
            $table->foreign('id_vehiculo')
                  ->references('id')
                  ->on('vehiculos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculo_responsables');
    }
}
