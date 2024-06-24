<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumoComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo_compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_insumo');
            $table->string('proveedor')->nullable();
            $table->date('fecha_compra');
            $table->string('nfactura')->nullable();
            $table->decimal('bultos',10,2)->nullable();
            $table->decimal('litros',10,2)->nullable();
            $table->decimal('peso',10,2)->nullable();
            $table->decimal('semillas',10,2)->nullable();
            $table->decimal('precio',10,2);

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
        Schema::dropIfExists('insumo_compras');
    }
}
