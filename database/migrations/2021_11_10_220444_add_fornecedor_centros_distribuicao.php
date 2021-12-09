<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFornecedorCentrosDistribuicao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedor_centros_distribuicao', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 100);
            $table->string('representante', 255);
            $table->string('cnpj', 14)->nullable();
            $table->string('telefone', 11)->nullable();
            $table->string('inscricao_estadual', 12)->nullable();

            $table->foreignId('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');

            $table->foreignId('usuario_endereco_id');
            $table->foreign('usuario_endereco_id')->references('id')->on('usuario_enderecos');

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
        Schema::dropIfExists('fornecedor_centros_distribuicao');
    }
}
