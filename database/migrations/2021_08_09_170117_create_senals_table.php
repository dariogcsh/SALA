<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSenalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('senals', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_organizacion');
            $table->unsignedbigInteger('id_mibonificacion')->nullable();
            $table->unsignedbigInteger('id_antena')->nullable();
            $table->unsignedbigInteger('id_user');
            $table->text('nserie')->nullable();
            $table->date('activacion')->nullable();
            $table->integer('duracion');
            $table->decimal('costo', 10, 2);
            $table->string('estado');
            $table->string('nfactura')->nullable();

            $table->timestamps();

            $table->foreign('id_organizacion')
                  ->references('id')
                  ->on('organizacions');

            $table->foreign('id_mibonificacion')
                  ->references('id')
                  ->on('mibonificacions');

            $table->foreign('id_antena')
                  ->references('id')
                  ->on('antenas');

            $table->foreign('id_user')
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
        Schema::dropIfExists('senals');
    }
}
