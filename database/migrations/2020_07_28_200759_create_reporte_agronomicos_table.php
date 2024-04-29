<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReporteAgronomicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporte_agronomicos', function (Blueprint $table) {
            $table->string('OrgaReAg');
            $table->string('NumSReAg');
            $table->string('ClieReAg');
            $table->string('GranReAg');
            $table->string('CampReAg');
            $table->string('VariReAg');
            $table->string('CultReAg');
            $table->decimal('SupeReAg', 10, 2);
            $table->string('UOM1ReAg');
            $table->decimal('HumeReAg', 10, 2);
            $table->string('UOM2ReAg');
            $table->decimal('ReSMReAg', 10, 2);
            $table->string('UOM3ReAg');
            $table->decimal('ReSTReAg', 10, 2);
            $table->string('UOM4ReAg');
            $table->decimal('ReMHReAg', 10, 2);
            $table->string('UOM5ReAg');
            $table->decimal('ReMTReAg', 10, 2);
            $table->string('UOM6ReAg');
            $table->decimal('VelPReAg', 10, 2);
            $table->string('UOM7ReAg');
            $table->date('FecFReAg');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reporte_agronomicos');
    }
}
