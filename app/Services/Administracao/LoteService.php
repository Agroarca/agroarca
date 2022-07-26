<?php

namespace App\Services\Administracao;

use App\Enums\Estoque\OperacaoMovimentoLote;
use App\Enums\Pedidos\StatusPedido;
use App\Enums\Pedidos\TipoPedido;
use App\Exceptions\OperacaoIlegalException;
use App\Models\Estoque\Lote;
use App\Models\Estoque\MovimentoLote;
use App\Models\Pedidos\PedidoItem;
use Illuminate\Support\Facades\DB;

class LoteService
{

    public static function getLotesPedidoitem(PedidoItem $pedidoItem)
    {
        $produto = $pedidoItem->produto ?? $pedidoItem->itemListaPreco->produto;
        $quantidadeRestante = LoteService::getQuantidadeRestantePedidoItem($pedidoItem);

        $lotes = [
            'salvarMovimento' => route('admin.pedidos.pedidos.itens.lotes.movimento.salvar', $pedidoItem->id),
            'quantidadeRestante' => $quantidadeRestante,
            'lotes' => []
        ];

        if ($quantidadeRestante != 0) {
            array_push($lotes['lotes'], [
                'id' => 0,
                'nome' => "Sem Lote",
                'quantidade_disponivel' => 0,
                'quantidade_movimentos' => $quantidadeRestante
            ]);
        }

        foreach ($produto->lotes as $lote) {
            array_push($lotes['lotes'], [
                'id' => $lote->id,
                'nome' => $lote->nome,
                'quantidade_disponivel' => $lote->quantidade_disponivel,
                'quantidade_movimentos' => self::getMovimentosLotePedidoitem($pedidoItem, $lote)
            ]);
        }

        return $lotes;
    }

    public static function getMovimentosLotePedidoitem(PedidoItem $pedidoItem, Lote $lote)
    {
        return $lote->movimentoLotes()->where('pedido_item_id', $pedidoItem->id)->sum('quantidade');
    }

    public static function getQuantidadeRestantePedidoItem(PedidoItem $pedidoItem)
    {
        return $pedidoItem->quantidade - MovimentoLote::where('pedido_item_id', $pedidoItem->id)->sum('quantidade');
    }

    public static function adicionarMovimento(PedidoItem $pedidoItem, $loteId, $quantidade)
    {
        DB::transaction(function () use ($pedidoItem, $loteId, $quantidade) {
            if ($pedidoItem->pedido->status != StatusPedido::Aprovado) {
                throw new OperacaoIlegalException("Somente é possível alterar os lotes de um pedido Aprovado");
            }

            $operacao = ($pedidoItem->pedido->tipo == TipoPedido::Compra) ? OperacaoMovimentoLote::Soma : OperacaoMovimentoLote::Diminui;

            $movimento = MovimentoLote::firstOrNew([
                'lote_id' => $loteId,
                'pedido_item_id' => $pedidoItem->id,
                'operacao' => $operacao
            ]);

            if ($movimento->quantidade + $quantidade > $pedidoItem->quantidade) {
                throw new OperacaoIlegalException("Não é possível adicionar uma quantidade maior que a quantidade do item");
            }

            if ($operacao == OperacaoMovimentoLote::Diminui && $movimento->lote->quantidade_disponivel < $quantidade) {
                throw new OperacaoIlegalException("O lote selecionado está sem estoque, não é possível adicionar");
            }

            $movimento->quantidade += $quantidade;

            if ($pedidoItem->pedido->tipo != TipoPedido::Compra) {
                $reserva = $pedidoItem->reservasProduto;
                $reserva->quantidade -= $quantidade;
                $reserva->save();
            }

            $movimento->save();
            $movimento->lote->atualizarQuantidade();
            $movimento->lote->produto->atualizarQuantidade();
        });
    }

    public static function diminuirMovimento(PedidoItem $pedidoItem, $loteId, $quantidade)
    {
        DB::transaction(function () use ($pedidoItem, $loteId, $quantidade) {
            if ($pedidoItem->pedido->status != StatusPedido::Aprovado) {
                throw new OperacaoIlegalException("Somente é possível alterar os lotes de um pedido Aprovado");
            }

            $movimento = MovimentoLote::where([
                'lote_id' => $loteId,
                'pedido_item_id' => $pedidoItem->id
            ])->first();

            if ($movimento->quantidade - $quantidade < 0) {
                throw new OperacaoIlegalException("Não é possível diminuir a quantidade para menos de zero");
            }

            if ($movimento->operacao == OperacaoMovimentoLote::Soma && $movimento->lote->quantidade_disponivel < $quantidade) {
                throw new OperacaoIlegalException("O lote selecionado está sem estoque, não é possível diminuir");
            }

            $movimento->quantidade -= $quantidade;

            if ($pedidoItem->pedido->tipo != TipoPedido::Compra) {
                $reserva = $pedidoItem->reservasProduto;
                $reserva->quantidade += $quantidade;
                $reserva->save();
            }

            $movimento->save();
            $movimento->lote->atualizarQuantidade();
            $movimento->lote->produto->atualizarQuantidade();
        });
    }
}
