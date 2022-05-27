<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEstoqueItemListaPreco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itens_lista_preco', function (Blueprint $table) {
            $table->dropColumn('estoque_total');
            $table->dropColumn('estoque_vendido');
            $table->dropColumn('estoque_disponivel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itens_lista_preco', function (Blueprint $table) {
            $table->decimal('estoque_total', 10, 2)->nullable();
            $table->decimal('estoque_vendido', 10, 2)->nullable();
            $table->decimal('estoque_disponivel', 10, 2)->nullable();
        });
    }
}
