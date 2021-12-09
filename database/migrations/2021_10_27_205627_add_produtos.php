<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->nullable();
            $table->string('nome', 50);
            $table->string('descricao', 1000);
            $table->text('descricao_longa')->nullable();

            $table->foreignId('marca_id');
            $table->foreign('marca_id')->references('id')->on('marcas');

            $table->foreignId('tipo_produto_id');
            $table->foreign('tipo_produto_id')->references('id')->on('tipos_produto');

            $table->foreignId('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');

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
        Schema::dropIfExists('produtos');
    }
}
