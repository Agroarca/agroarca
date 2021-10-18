<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->smallInteger('tipo_pessoa');
            $table->string('cpf', 11)->nullable();
            $table->string('cnpj', 14)->nullable();
            $table->string('celular', 11);
            $table->smallInteger('status')->default(0);
            $table->smallInteger('tipo')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('tipo_pessoa');
            $table->dropColumn('cpf');
            $table->dropColumn('cnpj');
            $table->dropColumn('celular');
            $table->dropColumn('status');
            $table->dropColumn('tipo');
        });
    }
}
