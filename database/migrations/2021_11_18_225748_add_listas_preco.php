<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddListasPreco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listas_preco', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 100);
            $table->date('data');
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim');
            $table->decimal('ajuste_mensal', 5, 2);

            $table->foreignId('fornecedor_id');
            $table->foreign('fornecedor_id')->references('id')->on('usuarios');

            $table->softDeletes();
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
        Schema::dropIfExists('listas_preco');
    }
}
