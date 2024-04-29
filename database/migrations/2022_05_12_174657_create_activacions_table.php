<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organizacion_id');
            $table->unsignedBigInteger('pantalla_id')->nullable();
            $table->unsignedBigInteger('id_antena')->nullable();
            $table->unsignedbigInteger('id_user');
            $table->string('nserie')->nullable();
            $table->unsignedBigInteger('suscripcion_id');
            $table->string('duracion');
            $table->decimal('precio',10,2);
            $table->date('fecha')->nullable();
            $table->string('estado',50);
            $table->string('nfactura',50)->nullable();
            $table->timestamps();

            $table->foreign('organizacion_id')
                  ->references('id')
                  ->on('organizacions');
            $table->foreign('pantalla_id')
                  ->references('id')
                  ->on('pantallas');
            $table->foreign('id_antena')
                  ->references('id')
                  ->on('antenas');
            $table->foreign('suscripcion_id')
                  ->references('id')
                  ->on('suscripcions');
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
        Schema::dropIfExists('activacions');
    }
}
