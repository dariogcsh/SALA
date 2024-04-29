<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usados', function (Blueprint $table) {
            $table->id();
            $table->date('ingreso');
            $table->string('excliente')->nullable();
            $table->string('tipo');
            $table->string('marca');
            $table->string('modelo');
            $table->string('ano')->nullable();
            $table->string('nserie')->nullable();
            $table->string('patente')->nullable();
            $table->string('traccion')->nullable();
            $table->string('rodado')->nullable();
            $table->integer('horasm')->nullable();
            $table->integer('horast')->nullable();
            $table->string('desparramador')->nullable();
            $table->enum('agprecision',['SI','NO'])->default('NO');
            $table->string('nrodado')->nullable();
            $table->integer('rodadoest')->nullable();
            $table->string('plataforma')->nullable();
            $table->enum('cabina',['SI','NO'])->default('NO');
            $table->integer('hp')->nullable();
            $table->string('transmision')->nullable();
            $table->string('nseriemotor')->nullable();
            $table->enum('tomafuerza',['SI','NO'])->default('NO');
            $table->string('bombah')->nullable();
            $table->integer('botalon')->nullable();
            $table->integer('tanque')->nullable();
            $table->string('picos')->nullable();
            $table->enum('corte',['SI','NO'])->default('NO');
            $table->string('categoria')->nullable();
            $table->decimal('surcos', 10, 2);
            $table->string('monitor')->nullable();
            $table->string('dosificacion')->nullable();
            $table->string('fertilizacion')->nullable();
            $table->integer('tolva')->nullable();
            $table->integer('fertilizante')->nullable();
            $table->integer('distancia')->nullable();
            $table->string('reqhidraulico')->nullable();
            $table->integer('precio_reparacion')->nullable();
            $table->longText('comentario_reparacion')->nullable();
            $table->string('plataforma')->nullable();
            $table->integer('ancho_plataforma')->nullable();
            $table->string('configuracion_roto')->nullable();
            $table->integer('cantidad_rollos')->nullable();
            $table->decimal('espaciamiento', 10, 2)->nullable();
            $table->enum('cutter',['SI','NO'])->default('NO');
            $table->enum('monitor_roto',['SI','NO'])->default('NO');
            $table->string('estado');
            $table->integer('precio');
            $table->longText('comentarios')->nullable();
            $table->date('fechafact')->nullable();
            $table->string('reservado_para')->nullable();
            $table->date('fechareserva')->nullable();
            $table->date('fechahasta')->nullable();
            $table->unsignedbigInteger('id_sucursal');
            $table->unsignedbigInteger('id_vendedor');
            $table->unsignedbigInteger('id_vreserva')->nullable();
            $table->unsignedbigInteger('id_conectividad')->nullable();
            $table->timestamps();

            $table->foreign('id_sucursal')
                  ->references('id')
                  ->on('sucursals');

            $table->foreign('id_vendedor')
                  ->references('id')
                  ->on('users');

            $table->foreign('id_vreserva')
                  ->references('id')
                  ->on('users');

            $table->foreign('id_conectividad')
                  ->references('id')
                  ->on('conectividads');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usados');
    }
}
