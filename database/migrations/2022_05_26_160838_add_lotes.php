<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Dominio;

class AddLotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->decimal('quantidade_disponivel', 10, 2)->nullable();
            $table->decimal('quantidade_total', 10, 2)->nullable();
            $table->date('data_vencimento');

            $table->foreignId('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');

            Dominio::criarCampo($table);

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
        Schema::dropIfExists('lotes');
    }
}
