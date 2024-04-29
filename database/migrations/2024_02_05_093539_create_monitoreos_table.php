<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoreosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoreos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_organizacion');
            $table->integer('anofiscal');
            $table->string('mes_facturacion',30);
            $table->date('fecha_solicitada')->nullable();
            $table->integer('costo_total')->nullable();
            $table->string('estado',30)->nullable();
            $table->string('factura',30)->nullable();
            $table->date('fecha_facturada')->nullable();
            $table->string('tipo',10);
            $table->timestamps();

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
        Schema::dropIfExists('monitoreos');
    }
}
