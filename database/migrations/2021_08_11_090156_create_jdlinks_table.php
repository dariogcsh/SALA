<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function DI\string;

class CreateJdlinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jdlinks', function (Blueprint $table) {
            $table->id();
            $table->string('NumSMaq');
            $table->unsignedbigInteger('id_mibonificacion')->nullable();
            $table->enum('conectado',['SI','NO'])->default('NO');
            $table->enum('monitoreo',['SI','NO'])->default('NO');
            $table->date('fecha_comienzo')->nullable();
            $table->enum('soporte_siembra',['SI','NO'])->default('NO');
            $table->enum('actualizacion_comp',['SI','NO','Realizado'])->default('NO');
            $table->enum('capacitacion_op',['SI','NO'])->default('NO');
            $table->enum('capacitacion_asesor',['SI','NO'])->default('NO');
            $table->enum('ordenamiento_agro',['SI','NO'])->default('NO');
            $table->enum('ensayo',['SI','NO','Realizado'])->default('NO');
            $table->enum('visita_inicial',['SI','NO','Realizada','Bonificado'])->default('NO');
            $table->date('fecha_visita')->nullable();
            $table->enum('check_list',['SI','NO','Realizado','Bonificado'])->default('NO');
            $table->enum('informes',['SI','NO'])->default('NO');
            $table->enum('alertas',['SI','NO'])->default('NO');
            $table->enum('alertas',['SI','NO','Cargado'])->default('NO');
            $table->enum('apivinculada',['SI','NO'])->default('NO');
            $table->enum('analisis_final',['SI','NO','Realizado','Bonificado'])->default('NO');
            $table->enum('limpieza_inyectores',['SI','NO','Realizada'])->default('NO');
            $table->integer('hectareas');
            $table->decimal('costo', 10, 2);
            $table->enum('contrato_firmado',['SI','NO','Validado'])->default('NO');
            $table->enum('factura',['SI','NO'])->default('NO');
            $table->integer('anofiscal');
            $table->date('vencimiento_contrato')->nullable();
            $table->string('asesor');
            $table->timestamps();

            $table->foreign('id_mibonificacion')
                  ->references('id')
                  ->on('mibonificacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jdlinks');
    }
}
