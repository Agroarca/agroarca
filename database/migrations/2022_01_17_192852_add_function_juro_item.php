<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFunctionJuroItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        create function juroItemListaPreco(idItem bigint, dataItem date)
        returns double deterministic
        begin
            declare dataReferencia date;
            declare ajusteMensal double;
            declare preco double;

            select lp.data, lp.ajuste_mensal, ilp.preco_quilo
            into dataReferencia, ajusteMensal, preco
            from listas_preco lp
            join itens_lista_preco ilp on ilp.lista_preco_id = lp.id
            where ilp.id = idItem;

            return calcJuroItemListaPreco(dataReferencia, dataItem, ajusteMensal, preco);
        end
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop function if exists juroItemListaPreco;');
    }
}
