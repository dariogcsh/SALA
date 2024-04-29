<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilidads', function (Blueprint $table) {
            $table->string('NumSMaq');
            $table->string('NombUtil');
            $table->string('CateUtil');
            $table->string('SeriUtil');
            $table->date('FecIUtil');
            $table->time('HorIUtil');
            $table->date('FecFUtil');
            $table->time('HorFUtil');
            $table->decimal('ValoUtil', 10, 2);
            $table->string('UOMUtil');
            $table->string('CultUtil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utilidads');
    }
}
