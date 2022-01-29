<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExcessaoIcmsEstado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icms_produto_estado', function (Blueprint $table) {
            $table->id();

            $table->decimal('icms', 5, 2);

            $table->foreignId('estado_id');
            $table->foreign('estado_id')->references('id')->on('estados');

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
        Schema::dropIfExists('icms_produto_estado');
    }
}
