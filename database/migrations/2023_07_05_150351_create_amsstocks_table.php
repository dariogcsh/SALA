<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmsstocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amsstocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_antena')->nullable();
            $table->unsignedbigInteger('id_pantalla')->nullable();
            $table->unsignedbigInteger('id_mtg')->nullable();
            $table->unsignedbigInteger('id_estacion')->nullable();
            $table->unsignedbigInteger('id_atu')->nullable();
            $table->unsignedbigInteger('id_ati')->nullable();
            $table->unsignedbigInteger('id_cdl')->nullable();
            $table->unsignedbigInteger('id_cds')->nullable();
            $table->string('estado');
            $table->integer('nasignacion')->nullable();
            $table->string('nserie')->nullable();
            $table->string('equipo')->nullable();
            $table->string('firma')->nullable();
            $table->date('fechaventa')->nullable();
        
            $table->timestamps();

            $table->foreign('id_antena')
                  ->references('id')
                  ->on('antenas');

            $table->foreign('id_pantalla')
                ->references('id')
                ->on('pantallas');

            $table->foreign('id_mtg')
                ->references('id')
                ->on('mtgs');

            $table->foreign('id_estacion')
                ->references('id')
                ->on('estacions');

            $table->foreign('id_atu')
                ->references('id')
                ->on('atus');

            $table->foreign('id_ati')
                ->references('id')
                ->on('atis');

            $table->foreign('id_cdl')
                ->references('id')
                ->on('cdls');

            $table->foreign('id_cds')
                ->references('id')
                ->on('cds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amsstocks');
    }
}
