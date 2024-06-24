<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_granja')->nullable();
            $table->unsignedBigInteger('org_id');
            $table->string('nombre')->nullable();
            $table->string('name')->nullable();
            $table->string('farm')->nullable();
            $table->string('client')->nullable();
            $table->timestamps();

            
            $table->foreign('id_granja')
                  ->references('id')
                  ->on('granjas');

            $table->foreign('org_id')
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
        Schema::dropIfExists('lotes');
    }
}
