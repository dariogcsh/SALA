<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizacions', function (Blueprint $table) {
            $table->id();
            $table->integer('CodiOrga')->nullable();
            $table->string('NombOrga')->unique();
            $table->unsignedbigInteger('CodiSucu');
            $table->string('InscOrga');
            $table->timestamps();
            
            $table->foreign('CodiSucu')
                  ->references('id')
                  ->on('sucursals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizacions');
    }
}
