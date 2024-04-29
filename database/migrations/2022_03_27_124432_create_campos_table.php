<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campos', function (Blueprint $table) {
            $table->id();
            $table->integer('org_id');
            $table->string('field_id');
            $table->string('archived',10);
            $table->decimal('field_ha', 10, 2);
            $table->string('boundary',250);
            $table->string('adr',250);
            $table->string('op_id',250);
            $table->string('op_type',250);
            $table->string('op_crop',250);
            $table->decimal('op_ha', 10, 2);
            $table->decimal('op_rinde', 10, 2);
            $table->decimal('op_hum', 10, 2);
            $table->date('op_ini');
            $table->date('op_fin');
            $table->date('op_date');

            $table->foreign('org_id')
                  ->references('CodiOrga')
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
        Schema::dropIfExists('campos');
    }
}
