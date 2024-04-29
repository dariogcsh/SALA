<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonificacions', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->integer('descuento')->nullable();
            $table->integer('costo')->nullable();
            $table->string('imagen');
            $table->string('descripcion');
            $table->date('desde');
            $table->date('hasta');
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
        Schema::dropIfExists('bonificacions');
    }
}
