<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBaseFreteItensListaPreco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itens_lista_preco', function (Blueprint $table) {
            $table->decimal('base_frete', 6, 2)->default(0);
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
            $table->dropColumn('base_frete');
        });
    }
}
