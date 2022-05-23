<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\Dominio;
use App\Traits\UsuarioDominio;

class AddDominioIdTabelas extends Migration
{
    private $tables = [
        'fornecedor_centros_distribuicao',
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
                Dominio::criarCampo($table);
            });
        }

        Schema::table('usuarios', function (Blueprint $table) {
            UsuarioDominio::criarCampo($table);
        });
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
                Dominio::removerCampo($table);
            });
        }

        Schema::table('usuarios', function (Blueprint $table) {
            UsuarioDominio::removerCampo($table);
        });
    }
}
