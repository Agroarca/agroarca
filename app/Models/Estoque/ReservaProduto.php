<?php

namespace App\Models\Estoque;

use App\Models\Pedidos\PedidoItem;
use App\Models\Produtos\Produto;
use App\Traits\Dominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaProduto extends Model
{
    use HasFactory, Dominio;

    protected $table = 'reservas_produto';
    protected $fillable = [
        'quantidade',
        'produto_id',
        'pedido_item_id',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function pedidoItem()
    {
        return $this->belongsTo(PedidoItem::class);
    }
}
