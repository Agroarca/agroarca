<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemListaPreco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_lista_preco', function (Blueprint $table) {
            $table->id();
            $table->decimal('preco_quilo', 8, 2);
            $table->bigInteger('estoque_total')->nullable();
            $table->bigInteger('estoque_vendido')->default(0);
            $table->bigInteger('estoque_disponivel')->nullable();

            $table->foreignId('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');

            $table->foreignId('lista_preco_id');
            $table->foreign('lista_preco_id')->references('id')->on('listas_preco');

            $table->softDeletes();
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
        Schema::dropIfExists('itens_lista_preco');
    }
}
