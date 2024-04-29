<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->id('CodiInfo');
            $table->date('FecIInfo');
            $table->date('FecFInfo');
            $table->string('NumSMaq');
            $table->integer('CodiOrga');
            $table->string('TipoInfo');
            $table->string('CultInfo');
            $table->longText('URLInfo');
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
        Schema::dropIfExists('informes');
    }
}
