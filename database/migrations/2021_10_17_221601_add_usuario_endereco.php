<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsuarioEndereco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_enderecos', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 100);
            $table->string('endereco', 100);
            $table->string('bairro', 100);
            $table->string('complemento', 100);
            $table->string('numero', 20);
            $table->string('cep', 8);

            $table->foreignId('cidade_id');
            $table->foreign('cidade_id')->references('id')->on('cidades');

            $table->foreignId('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');

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
        Schema::dropIfExists('usuario_enderecos');
    }
}
