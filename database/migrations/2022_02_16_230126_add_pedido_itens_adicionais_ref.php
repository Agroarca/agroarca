<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPedidoItensAdicionaisRef extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedido_itens', function (Blueprint $table) {
            $table->foreignId('pedido_item_pai_id')->nullable();
            $table->foreign('pedido_item_pai_id')->references('id')->on('pedido_itens');
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
            $table->dropForeign(['pedido_item_pai_id']);
            $table->dropColumn('pedido_item_pai_id');
        });
    }
}
