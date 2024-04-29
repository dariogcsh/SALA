<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaquinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquinas', function (Blueprint $table) {
            $table->id();
            $table->string('NumSMaq', 50)->unique();
            $table->string('TipoMaq');
            $table->string('MarcMaq');
            $table->string('ModeMaq');
            $table->unsignedBigInteger('CodiOrga');
            $table->integer('CanPMaq')->nullable();
            $table->decimal('MaicMaq', 10, 2)->nullable();
            $table->string('InscMaq');
            $table->timestamps();

            
            $table->foreign('CodiOrga')
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
        Schema::dropIfExists('maquinas');
    }
}
