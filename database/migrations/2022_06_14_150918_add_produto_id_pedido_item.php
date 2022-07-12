<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProdutoIdPedidoItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedido_itens', function (Blueprint $table) {
            $table->foreignId('produto_id')->nullable();
            $table->foreign('produto_id')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedido_itens', function (Blueprint $table) {
            $table->dropForeign(['produto_id']);
        });
    }
}
