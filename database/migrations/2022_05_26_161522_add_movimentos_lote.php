<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Dominio;

class AddMovimentosLote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentos_lote', function (Blueprint $table) {
            $table->id();

            $table->decimal('quantidade', 10, 2)->nullable();
            $table->smallInteger('operacao');

            $table->foreignId('lote_id');
            $table->foreign('lote_id')->references('id')->on('lotes');

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
        Schema::dropIfExists('movimentos_lote');
    }
}
