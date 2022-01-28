<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPedidoItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_itens', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('quantidade')->default(0);
            $table->bigInteger('quantidade_entregue')->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('ajuste', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('preco_quilo', 8, 2)->default(0);

            $table->date('data_entrega')->nullable();

            $table->foreignId('pedido_id');
            $table->foreign('pedido_id')->references('id')->on('pedidos');

            $table->foreignId('item_lista_preco_id');
            $table->foreign('item_lista_preco_id')->references('id')->on('itens_lista_preco');

            $table->foreignId('endereco_id')->nullable();
            $table->foreign('endereco_id')->references('id')->on('usuario_enderecos');

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
        Schema::dropIfExists('pedido_itens');
    }
}
