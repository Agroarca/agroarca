<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEnderecoPedidoItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedido_itens', function (Blueprint $table) {
            $table->dropForeign(['endereco_id']);
            $table->dropColumn('endereco_id');
            $table->dropColumn('data_entrega');
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
            $table->date('data_entrega')->nullable();

            $table->foreignId('endereco_id')->nullable();
            $table->foreign('endereco_id')->references('id')->on('usuario_enderecos');
        });
    }
}
