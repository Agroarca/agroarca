<?php

namespace App\Models\Pedidos;

use App\Models\Cadastros\UsuarioEndereco;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    use HasFactory;

    protected $touches = ['pedido'];
    protected $table = 'pedido_itens';
    protected $fillable = [
        'quantidade',
        'quantidade_entregue',
        'preco_quilo',
        'subtotal',
        'ajuste',
        'total',
        'data_entrega',
        'pedido_id',
        'item_lista_preco_id',
        'endereco_id',
        'pedido_item_pai_id',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function itemListaPreco()
    {
        return $this->belongsTo(ItemListaPreco::class);
    }

    public function usuarioEndereco()
    {
        return $this->belongsTo(UsuarioEndereco::class);
    }

    public function pedidoItemPai()
    {
        return $this->belongsTo(PedidoItem::class);
    }

    public function pedidoItensAdicionais()
    {
        return $this->hasMany(PedidoItem::class, 'pedido_item_pai_id');
    }
}
