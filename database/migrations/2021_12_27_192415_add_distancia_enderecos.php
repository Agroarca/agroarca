<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDistanciaEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distancia_enderecos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('endereco_origem_id');
            $table->foreign('endereco_origem_id')->references('id')->on('usuario_enderecos')->onDelete('cascade');

            $table->foreignId('endereco_destino_id');
            $table->foreign('endereco_destino_id')->references('id')->on('usuario_enderecos')->onDelete('cascade');

            $table->decimal('distancia', 12, 2);

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
        Schema::dropIfExists('distancia_enderecos');
    }
}
