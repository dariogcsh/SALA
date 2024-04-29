<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMezclaInsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mezcla_insus', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_mezcla');
            $table->unsignedbigInteger('id_insumo');
            $table->decimal('cantidad',10,2);
            $table->timestamps();

            $table->foreign('id_mezcla')
                  ->references('id')
                  ->on('mezclas');

            $table->foreign('id_insumo')
                  ->references('id')
                  ->on('insumos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mezcla_insus');
    }
}
