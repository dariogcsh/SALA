<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImgNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('img_noticias', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_noticia');
            $table->string('nombre',255);
            $table->timestamps();

            $table->foreign('id_noticia')
                  ->references('id')
                  ->on('noticias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('img_noticias');
    }
}
