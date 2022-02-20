<?php

use App\Enums\Pedidos\StatusPedido;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPedido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            $table->smallInteger('status')->default(StatusPedido::Aberto);
            $table->decimal('frete', 12, 2)->default(0);
            $table->decimal('icms', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->foreignId('usuario_id')->nullable();
            $table->foreign('usuario_id')->references('id')->on('usuarios');

            $table->text('observacao')->nullable();

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
        Schema::dropIfExists('pedidos');
    }
}
