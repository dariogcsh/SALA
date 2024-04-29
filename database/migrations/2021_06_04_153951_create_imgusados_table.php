<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImgusadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imgusados', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_usado');
            $table->string('ruta');
            $table->timestamps();
            
            $table->foreign('id_usado')
                  ->references('id')
                  ->on('usados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imgusados');
    }
}
