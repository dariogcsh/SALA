<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquetes', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_maquina');
            $table->date('desde');
            $table->date('hasta');
            $table->enum('contrato_firmado',['SI','NO'])->default('NO');
            $table->decimal('importe', 10, 2);
            $table->string('estado');
            $table->timestamps();

            $table->foreign('id_maquina')
                  ->references('id')
                  ->on('maquinas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paquetes');
    }
}
