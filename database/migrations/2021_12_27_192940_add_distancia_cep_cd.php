<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDistanciaCepCd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distancia_cep_cd', function (Blueprint $table) {
            $table->id();

            $table->string('cep', 8);

            $table->foreignId('endereco_id');
            $table->foreign('endereco_id')->references('id')->on('usuario_enderecos')->onDelete('cascade');

            $table->decimal('distancia', 12, 2);

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
        Schema::dropIfExists('distancia_cep_cd');
    }
}
