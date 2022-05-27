<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Dominio;

class AddReservasProduto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas_produto', function (Blueprint $table) {
            $table->id();

            $table->decimal('quantidade', 10, 2)->nullable();

            $table->foreignId('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');

            $table->foreignId('pedido_item_id');
            $table->foreign('pedido_item_id')->references('id')->on('pedido_itens');

            Dominio::criarCampo($table);

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
        Schema::dropIfExists('reservas_produto');
    }
}
