<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMibonificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mibonificacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_bonificacion');
            $table->unsignedbigInteger('id_organizacion');
            $table->string('estado');
            $table->timestamps();

            $table->foreign('id_bonificacion')
                  ->references('id')
                  ->on('bonificacions');

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
        Schema::dropIfExists('mibonificacions');
    }
}
