<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEntregaItenslistapreco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itens_lista_preco', function (Blueprint $table) {
            $table->dropColumn('data_inicial_entrega');
            $table->dropColumn('data_final_entrega');
            $table->dropColumn('minimo_dias_entrega');
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
            $table->dateTime('data_inicial_entrega')->nullable();
            $table->dateTime('data_final_entrega')->nullable();
            $table->integer('minimo_dias_entrega')->default(0);
        });
    }
}
