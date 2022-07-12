d_<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddPedidoItemMovimentoLote extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('movimentos_lote', function (Blueprint $table) {
                $table->foreignId('pedido_item_id')->nullable();
                $table->foreign('pedido_item_id')->references('id')->on('pedido_itens');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            //
        }
    }
