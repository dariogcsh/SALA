<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGranjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('granjas', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_cliente');
            $table->string('nombre');
            $table->timestamps();

            
            $table->foreign('id_cliente')
                  ->references('id')
                  ->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('granjas');
    }
}
