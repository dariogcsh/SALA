<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBauchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bauchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_tipobaucher');
            $table->string('nombre',100);
            $table->string('descripcion',255);
            $table->decimal('descuento', 10, 2);
            $table->string('foto',255);
            $table->date('desde');
            $table->date('hasta');
            $table->timestamps();

            $table->foreign('id_tipobaucher')
                  ->references('id')
                  ->on('tipobauchers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bauchers');
    }
}
