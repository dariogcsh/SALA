<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregaPasosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrega_pasos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_entrega');
            $table->unsignedbigInteger('id_paso');
            $table->unsignedbigInteger('id_user');
            $table->string('valor_condicion')->nullable();
            $table->string('detalle');
            $table->timestamps();

            $table->foreign('id_entrega')
                  ->references('id')
                  ->on('entregas');
            $table->foreign('id_paso')
                  ->references('id')
                  ->on('pasos');
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
        Schema::dropIfExists('entrega_pasos');
    }
}
