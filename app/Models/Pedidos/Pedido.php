<?php

namespace App\Models\Pedidos;

use App\Models\Cadastros\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $fillable = [
        'status',
        'frete',
        'icms',
        'subtotal',
        'total',
        'usuario_id',
        'observacao',
        'data_entrega',
        'endereco_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function pedidoItens()
    {
        return  $this->hasMany(PedidoItem::class);
    }

    public function usuarioEndereco()
    {
        return $this->belongsTo(UsuarioEndereco::class);
    }
}
