<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCombustiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combustibles', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_cisterna');
            $table->unsignedbigInteger('id_usuario');
            $table->string('nserie')->nullable();
            $table->decimal('cantidad',10,2);
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('id_cisterna')
                  ->references('id')
                  ->on('cisternas');

            $table->foreign('id_usuario')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('combustibles');
    }
}
