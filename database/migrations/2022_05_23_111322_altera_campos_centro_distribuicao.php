<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\GooglePlaceId;

class AlteraCamposCentroDistribuicao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('centros_distribuicao', function (Blueprint $table) {
            $table->dropForeign('fornecedor_centros_distribuicao_usuario_id_foreign');
            $table->dropForeign('fornecedor_centros_distribuicao_usuario_endereco_id_foreign');
            $table->dropColumn('usuario_id');
            $table->dropColumn('usuario_endereco_id');

            $table->string('endereco', 100);
            $table->string('bairro', 100);
            $table->string('complemento', 100)->nullable();
            $table->string('numero', 20);
            $table->string('cep', 8);

            $table->foreignId('cidade_id');
            $table->foreign('cidade_id')->references('id')->on('cidades');

            GooglePlaceId::criarCampos($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('centros_distribuicao', function (Blueprint $table) {
            $table->dropForeign(['cidade_id']);
            $table->dropColumn([
                'endereco',
                'bairro',
                'complemento',
                'numero',
                'cep',
                'cidade_id'
            ]);

            GooglePlaceId::removerCampos($table);

            $table->foreignId('usuario_id');
            $table->foreign('usuario_id', 'fornecedor_centros_distribuicao_usuario_id_foreign')->references('id')->on('usuarios');

            $table->foreignId('usuario_endereco_id');
            $table->foreign('usuario_endereco_id', 'fornecedor_centros_distribuicao_usuario_endereco_id_foreign')->references('id')->on('usuario_enderecos');
        });
    }
}
