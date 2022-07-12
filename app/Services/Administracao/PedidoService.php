<?php

namespace App\Services\Administracao;

use App\Enums\Pedidos\ModalidadeFormaPagamento;
use App\Enums\Pedidos\StatusPedido;
use App\Enums\Pedidos\TipoPedido;
use App\Exceptions\OperacaoIlegalException;
use App\Helpers\Formatter;
use App\Models\Pedidos\FormaPagamento;
use App\Models\Pedidos\Pedido;
use App\Models\Pedidos\PedidoItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PedidoService
{
    public static function getDadosPedido(Pedido $pedido)
    {
        return [
            'tipo' => TipoPedido::getName($pedido->tipo),
            'usuarioId' => $pedido->usuario_id,
            'status' => StatusPedido::getName($pedido->status),
            'frete' => $pedido->frete,
            'icms' => $pedido->icms,
            'subtotal' => $pedido->subtotal,
            'total' => $pedido->total,
            'data_pagamento' => is_null($pedido->data_pagamento) ? null : Carbon::parse($pedido->data_pagamento),
            'data_entrega' => is_null($pedido->data_entrega) ? null : Carbon::parse($pedido->data_entrega),
            'usuario' => $pedido->usuario_id ? $pedido->usuario->nome : '',
            'apiUsuarios' => route('api.usuarios'),
            'adicionarItem' => route('admin.pedidos.pedidos.itens.adicionar', $pedido->id),
            'apiProdutos' => ($pedido->tipo == TipoPedido::Compra) ? route('api.produtos') : route('api.itensListaPreco'),
            'forma_pagamento_id' => $pedido->forma_pagamento_id,
            'formasPagamento' => self::getformasPagamento(),
            'enderecosEntrega' => ($pedido->usuario_id) ? self::getEnderecosEntrega($pedido) : [],
            'endereco_id' => $pedido->endereco_id,
            'itens' => self::getDadosPedidoItens($pedido),
            'observacao' => $pedido->observacao,
            'camposDesabilitados' => self::getCamposDesabilitados($pedido),
            'atualizar' => route('admin.pedidos.pedidos.atualizar', $pedido->id),
            'aprovar' => in_array($pedido->status, [StatusPedido::Aberto, StatusPedido::Analise]) ? route('admin.pedidos.pedidos.aprovar', $pedido->id) : null,
            'submeter' => $pedido->status == StatusPedido::Aberto ? route('admin.pedidos.pedidos.submeter', $pedido->id) : null,
            'cancelar' => $pedido->status != StatusPedido::Aberto ? route('admin.pedidos.pedidos.cancelar', $pedido->id) : null,
            'excluir' => $pedido->status == StatusPedido::Aberto ? route('admin.pedidos.pedidos.excluir', $pedido->id) : null
        ];
    }

    public static function getDadosPedidoItens(Pedido $pedido)
    {
        $itens = [];
        foreach ($pedido->pedidoItens as $item) {
            array_push($itens, [
                'id' => $item->id,
                'quantidade' => $item->quantidade,
                'preco_quilo' => $item->preco_quilo,
                'frete' => $item->frete,
                'icms' => $item->icms,
                'subtotal' => Formatter::preco($item->subtotal),
                'total' => Formatter::preco($item->total),
                'produto' => ($pedido->tipo == TipoPedido::Compra) ? $item->produto->nome : $item->itemListaPreco->produto->nome,
                'atualizar' => route('admin.pedidos.pedidos.itens.atualizar', [$pedido->id, $item->id]),
                'excluir' => route('admin.pedidos.pedidos.itens.excluir', [$pedido->id, $item->id]),
                'lotes' => route('admin.pedidos.pedidos.itens.lotes', $item->id)
            ]);
        }

        return $itens;
    }

    public static function getFormasPagamento()
    {
        $formasPagamento = [];
        foreach (FormaPagamento::all() as $formaPagamento) {
            array_push($formasPagamento, [
                'id' => $formaPagamento->id,
                'nome' => $formaPagamento->nome,
                'tipo' => $formaPagamento->tipo,
                'modalidade' => $formaPagamento->modalidade,
                'mostrarData' => $formaPagamento->modalidade == ModalidadeFormaPagamento::Credito
            ]);
        }

        return $formasPagamento;
    }

    public static function getEnderecosEntrega(Pedido $pedido)
    {
        $itens = [];

        foreach ($pedido->usuario->enderecos as $endereco) {
            array_push($itens, [
                'id' => $endereco->id,
                'nome' => $endereco->nome,
            ]);
        }

        return $itens;
    }

    public static function getCamposDesabilitados(Pedido $pedido)
    {
        if ($pedido->status != StatusPedido::Aberto) {
            return [
                'frete',
                'icms',
                'forma_pagamento_id',
                'data_pagamento',
                'endereco_id',
                'data_entrega',
            ];
        }

        return [];
    }

    public static function aprovarPedido(Pedido $pedido)
    {
        DB::transaction(function () use ($pedido) {
            if ($pedido->status != StatusPedido::Analise) {
                throw new OperacaoIlegalException("Não é possível aprovar um pedido nesse Status");
            }

            $pedido->status = StatusPedido::Aprovado;
            $pedido->save();
        });
    }

    public static function cancelarPedido(Pedido $pedido)
    {
        DB::transaction(function () use ($pedido) {
            if ($pedido->status != StatusPedido::Analise && $pedido->status != StatusPedido::Aprovado) {
                throw new OperacaoIlegalException("Não é permitido cancelar um pedido nesse status");
            }

            $pedido->status = StatusPedido::Cancelado;

            foreach ($pedido->pedidoItens() as $pedidoItem) {
                foreach ($pedidoItem->pedidoItensAdicionais as $adicional) {
                    $adicional->reservasProduto()->delete();
                }

                $pedidoItem->reservasProduto()->delete();
            }

            $pedido->save();
        });
    }
}
