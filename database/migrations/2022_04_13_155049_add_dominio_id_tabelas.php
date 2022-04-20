<?php

use App\Models\Administracao\Dominio;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddDominioIdTabelas extends Migration
{
    private $tables = [
        'fornecedor_centros_distribuicao',
        'usuarios',
        'usuario_enderecos',
        'categorias',
        'icms_produto_estado',
        'marcas',
        'produtos',
        'produto_imagens',
        'tipos_produto',
        'itens_lista_preco',
        'listas_preco',
        'pedidos',
        'pedido_itens',
    ];

    public function up()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('dominio_id')->nullable();
                $table->foreign('dominio_id')->references('id')->on('dominios');
            });

            DB::table($table)->update(['dominio_id' => Dominio::first()->id]);

            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('dominio_id')->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign(['dominio_id']);
                $table->dropColumn('dominio_id');
            });
        }
    }
}
