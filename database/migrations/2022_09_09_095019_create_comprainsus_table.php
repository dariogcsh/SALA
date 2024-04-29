<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprainsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprainsus', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_insumo');
            $table->date('fecha');
            $table->integer('bultos')->nullable();
            $table->decimal('cantidadxbulto',10,2)->nullable();
            $table->decimal('litros',10,2)->nullable();
            $table->decimal('preciounitario',10,2);
            $table->decimal('preciototal',10,2);
            $table->timestamps();

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
        Schema::dropIfExists('comprainsus');
    }
}
