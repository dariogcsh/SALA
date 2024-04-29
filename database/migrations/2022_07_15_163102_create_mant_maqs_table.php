<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantMaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mant_maqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_paquetemant');
            $table->string('pin',55);
            $table->enum('realizado',['SI','NO'])->default('NO');
            $table->decimal('horas',10,2)->nullable();
            $table->date('fecha')->nullable();
            $table->integer('cor')->nullable();
            $table->string('estado');
            $table->timestamps();

            $table->foreign('id_paquetemant')
                  ->references('id')
                  ->on('paquetemants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mant_maqs');
    }
}
