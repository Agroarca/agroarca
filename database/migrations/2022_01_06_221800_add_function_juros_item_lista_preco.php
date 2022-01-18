<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFunctionJurosItemListaPreco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        create function calcJuroItemListaPreco(dataReferencia date, data date, ajuste_mensal double, preco double)
        returns double deterministic
        begin
            declare dias integer;
            declare meses integer;
            declare ajuste double;
            declare valor double;

            set meses = TIMESTAMPDIFF(MONTH, dataReferencia, data);
            set dias = - datediff(datareferencia, data - interval meses month);
            set ajuste = ajuste_mensal / 100;

            set valor = preco * pow(1 + ajuste, meses);
            set valor = valor + preco * (pow(1 + ajuste, 1) - 1) * dias / 30;
            return round(valor, 2);
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
        DB::unprepared('drop function if exists calcJuroItemListaPreco;');
    }
}
