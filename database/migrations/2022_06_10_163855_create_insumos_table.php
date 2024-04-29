<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_organizacion');
            $table->enum('categoria',['Variedad/Hibrido','Producto quimico']);
            $table->unsignedBigInteger('id_marcainsumo');
            $table->string('nombre');
            $table->string('tipo')->nullable();
            $table->string('principio_activo')->nullable();
            $table->string('concentracion')->nullable();
            $table->integer('bultos')->nullable();
            $table->decimal('cantxbulto',10,2)->nullable();
            $table->decimal('litros', 10,2)->nullable();
            $table->decimal('peso', 10,2)->nullable();
            $table->integer('semillas')->nullable();
            $table->string('precio')->nullable();
            $table->timestamps();
            
            $table->foreign('id_marcainsumo')
                  ->references('id')
                  ->on('marcainsumos');

            $table->foreign('id_organizacion')
                  ->references('id')
                  ->on('organizacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumos');
    }
}
