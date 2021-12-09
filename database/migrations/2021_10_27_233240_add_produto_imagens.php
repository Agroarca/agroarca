<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProdutoImagens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_imagens', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 200);
            $table->string('nome_arquivo');

            $table->foreignId('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');

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
        Schema::dropIfExists('produto_imagens');
    }
}
