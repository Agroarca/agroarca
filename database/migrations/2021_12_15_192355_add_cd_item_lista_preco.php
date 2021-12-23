<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCdItemListaPreco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itens_lista_preco', function (Blueprint $table) {
            $table->foreignId('centro_distribuicao_id');
            $table->foreign('centro_distribuicao_id')->references('id')->on('fornecedor_centros_distribuicao');
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
            $table->dropForeign(['centro_distribuicao_id']);
            $table->dropColumn('centro_distribuicao_id');
        });
    }
}
