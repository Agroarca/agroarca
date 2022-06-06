<?php

namespace App\Models\Produtos;

use App\Models\Estoque\Lote;
use App\Models\Estoque\ReservaProduto;
use App\Models\Pedidos\ItemListaPreco;
use App\Traits\Dominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produto extends Model
{
    use HasFactory, Dominio;
    protected $table = 'produtos';
    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'descricao_longa',
        'marca_id',
        'tipo_produto_id',
        'categoria_id',
        'icms_padrao',
        'quantidade_disponivel',
        'quantidade_total',
        'quantidade_reservada',
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function tipoProduto()
    {
        return $this->belongsTo(TipoProduto::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function imagens()
    {
        return $this->hasMany(ProdutoImagem::class);
    }

    public function itensListaPreco()
    {
        return $this->hasMany(ItemListaPreco::class);
    }

    public function icmsEstado()
    {
        return $this->hasMany(ICMSProdutoEstado::class);
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

    public function reservasProduto()
    {
        return $this->hasMany(ReservaProduto::class);
    }

    public function atualizarQuantidade()
    {
        DB::transaction(function () {
            foreach ($this->lotes as $lote) {
                $lote->atualizarQuantidade();
            }

            $this->quantidade_total = $this->lotes()->sum('quantidade_disponivel');
            $this->quantidade_reservada = $this->reservasProduto()->sum('quantidade');
            $this->quantidade_disponivel = $this->quantidade_total - $this->quantidade_reservada;

            $this->save();
        });
    }
}
