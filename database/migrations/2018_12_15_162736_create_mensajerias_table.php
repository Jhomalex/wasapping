<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensajeriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajerias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('campania');
            $table->longText('mensaje');
            $table->mediumText('archivo');
            $table->mediumText('url');
            $table->date('fecha');
            $table->time('horamin');
            $table->time('horamax');
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('mensajerias');
    }
}
