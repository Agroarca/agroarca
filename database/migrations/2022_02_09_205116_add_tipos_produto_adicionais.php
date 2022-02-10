<?php

use App\Models\Estoque\TipoProduto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTiposProdutoAdicionais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_produto_adicionais', function (Blueprint $table) {
            $table->foreignIdFor(TipoProduto::class, 'tipo_produto_id');
            $table->foreignIdFor(TipoProduto::class, 'tipo_produto_adicional_id');
            $table->primary(['tipo_produto_id', 'tipo_produto_adicional_id'], 'tipos_produto_adicionais_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_produto_adicionais');
    }
}
