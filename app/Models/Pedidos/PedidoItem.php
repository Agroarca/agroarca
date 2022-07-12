<?php

namespace App\Models\Pedidos;

use App\Models\Estoque\MovimentoLote;
use App\Models\Produtos\Produto;
use App\Traits\Dominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    use HasFactory, Dominio;

    protected $touches = ['pedido'];
    protected $table = 'pedido_itens';
    protected $fillable = [
        'quantidade',
        'quantidade_entregue',
        'preco_quilo',
        'subtotal',
        'ajuste',
        'frete',
        'icms',
        'total',
        'pedido_id',
        'item_lista_preco_id',
        'pedido_item_pai_id',
        'produto_id'
    ];

    public static function booted()
    {
        static::addGlobalScope('pedidoItensSemAdicionais', function ($query) {
            $query->whereNull('pedido_item_pai_id');
        });
    }

    public function getProdutoNomeAttribute()
    {
        return (!is_null($this->produto)) ? $this->produto->nome : $this->itemListaPreco->produto->nome;
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function itemListaPreco()
    {
        return $this->belongsTo(ItemListaPreco::class);
    }

    public function pedidoItemPai()
    {
        return $this->belongsTo(PedidoItem::class);
    }

    public function pedidoItensAdicionais()
    {
        return $this->hasMany(PedidoItem::class, 'pedido_item_pai_id')->withoutGlobalScope('pedidoItensSemAdicionais');
    }

    public function reservasProduto()
    {
        return $this->hasOne(ReservaProduto::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function movimentosLote()
    {
        return $this->hasMany(MovimentoLote::class);
    }
}
