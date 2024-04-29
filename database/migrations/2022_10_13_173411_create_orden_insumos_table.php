<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_insumos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_ordentrabajo');
            $table->string('insumo');
            $table->decimal('unidades',10,2)->nullable();
            $table->decimal('kg',10,2)->nullable();
            $table->decimal('lts',10,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_insumos');
    }
}
