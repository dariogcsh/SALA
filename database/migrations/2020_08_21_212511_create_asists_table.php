<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asists', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_asistenciatipo');
            $table->unsignedbigInteger('id_user');
            $table->unsignedbigInteger('id_maquina');
            $table->unsignedbigInteger('id_pantalla')->nullable();
            $table->unsignedbigInteger('id_antena')->nullable();
            //$table->date('FeAcAsis')->nullable();
            $table->enum('MaPaAsis',['SI','NO'])->default('NO');
            $table->string('PiloAsis')->nullable();
            $table->enum('TipoAsis',['Permanente','Intermitente'])->nullable();
            $table->enum('PrimAsis',['SI','NO'])->default('NO');
            $table->string('CondAsis')->nullable();
            $table->enum('PrueAsis',['SI','NO'])->default('NO');
            $table->string('CualAsis')->nullable();
            $table->string('CambAsis')->nullable();
            $table->enum('DeriAsis',['Telefónica','Turno para soporte a campo']);
            $table->string('CodDAsis')->nullable();
            $table->string('DescAsis');
            $table->string('EstaAsis');
            $table->string('TecnAsis')->nullable();
            $table->string('ResuAsis')->default("NO");
            $table->integer('CMinAsis')->nullable();
            $table->string('DeReAsis')->nullable();
            $table->timestamps();
            
            $table->foreign('id_asistenciatipo')
                  ->references('id')
                  ->on('asistenciatipos');

            $table->foreign('id_user')
                  ->references('id')
                  ->on('users');

            $table->foreign('id_maquina')
                  ->references('id')
                  ->on('maquinas');

            $table->foreign('id_pantalla')
                  ->references('id')
                  ->on('pantallas');

            $table->foreign('id_antena')
                  ->references('id')
                  ->on('antenas');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asists');
    }
}
