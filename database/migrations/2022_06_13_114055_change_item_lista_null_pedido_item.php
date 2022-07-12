p[edido<?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        class ChangeItemListaNullPedidoItem extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::table('pedido_itens', function (Blueprint $table) {
                    $table->foreignId('item_lista_preco_id')->nullable(true)->change();
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
                    $table->foreignId('item_lista_preco_id')->nullable(false)->change();
                });
            }
        }
