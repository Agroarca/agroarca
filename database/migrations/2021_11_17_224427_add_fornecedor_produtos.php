<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFornecedorProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos_fornecedor', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('estoque_total')->nullable();
            $table->bigInteger('estoque_vendido')->default(0);
            $table->bigInteger('estoque_disponivel')->nullable();

            $table->foreignId('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');

            $table->foreignId('fornecedor_id');
            $table->foreign('fornecedor_id')->references('id')->on('usuarios');

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
        Schema::dropIfExists('produtos_fornecedor');
    }
}
