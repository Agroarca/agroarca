<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstoqueProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->decimal('quantidade_total', 10, 2)->nullable();
            $table->decimal('quantidade_vendido', 10, 2)->nullable();
            $table->decimal('quantidade_disponivel', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('quantidade_total');
            $table->dropColumn('quantidade_vendido');
            $table->dropColumn('quantidade_disponivel');
        });
    }
}
