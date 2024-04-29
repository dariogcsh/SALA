<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReclamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reclamos', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('id_organizacion');
            $table->unsignedbigInteger('id_sucursal');
            $table->date('fecha');
            $table->string('origen');
            $table->string('hallazgo');
            $table->string('proceso');
            $table->string('nombre_cliente');
            $table->string('descripcion',40000);
            $table->string('estado');
            $table->string('causa')->nullable();
            $table->unsignedbigInteger('id_user_responsable')->nullable();
            $table->date('fecha_contacto')->nullable();
            $table->string('accion_contingencia')->nullable();
            $table->unsignedbigInteger('id_user_contingencia')->nullable();
            $table->date('fecha_limite_contingencia')->nullable();
            $table->string('accion_correctiva')->nullable();
            $table->unsignedbigInteger('id_user_correctiva')->nullable();
            $table->date('fecha_limite_correctiva')->nullable();
            $table->string('verificacion_implementacion')->nullable();
            $table->unsignedbigInteger('id_user_implementacion')->nullable();
            $table->date('fecha_implementacion')->nullable();
            $table->string('medicion_eficiencia')->nullable();
            $table->unsignedbigInteger('id_user_eficiencia')->nullable();
            $table->date('fecha_eficiencia')->nullable();
            $table->timestamps();

            $table->foreign('id_user_responsable')
                  ->references('id')
                  ->on('users');

            $table->foreign('id_user_contingencia')
                    ->references('id')
                    ->on('users');

            $table->foreign('id_user_implementacion')
                    ->references('id')
                    ->on('users');

            $table->foreign('id_user_eficiencia')
                    ->references('id')
                    ->on('users');

            $table->foreign('id_user_correctiva')
                    ->references('id')
                    ->on('users');

            $table->foreign('id_organizacion')
                    ->references('id')
                    ->on('organizacions');

                $table->foreign('id_sucursal')
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
        Schema::dropIfExists('reclamos');
    }
}
