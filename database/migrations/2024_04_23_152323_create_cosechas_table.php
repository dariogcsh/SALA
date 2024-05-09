<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Ramsey\Uuid\v1;

class CreateCosechasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cosechas', function (Blueprint $table) {
            $table->id();
            $table->string('cliente');
            $table->string('granja');
            $table->string('organizacion');
            $table->string('campo');
            $table->string('nombre_maquina');
            $table->string('pin');
            $table->string('operador');
            $table->string('variedad');
            $table->string('cultivo');
            $table->decimal('superficie',10,1);
            $table->decimal('humedad',10,1);
            $table->decimal('rendimiento',10,1);
            $table->decimal('combustible',10,1);
            $table->date('inicio');
            $table->date('fin');
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
        Schema::dropIfExists('cosechas');
    }
}
