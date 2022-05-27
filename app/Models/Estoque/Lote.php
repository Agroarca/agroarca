<?php

namespace App\Models\Estoque;

use App\Enums\Estoque\OperacaoMovimentoLote;
use App\Models\Produtos\Produto;
use App\Traits\Dominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lote extends Model
{
    use HasFactory, Dominio;
    protected $table = 'lotes';
    protected $fillable = [
        'nome',
        'quantidade_disponivel',
        'quantidade_total',
        'data_vencimento',
        'produto_id',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function movimentoLotes()
    {
        return $this->hasMany(MovimentoLote::class);
    }

    public function atualizarQuantidade()
    {
        DB::transaction(function () {
            try {
                DB::raw('lock table lotes write, movimentos_lotes read');

                $this->quantidade_disponivel = $this->movimentoLotes()->where('operacao', OperacaoMovimentoLote::Soma)->sum('quantidade');
                $this->quantidade_disponivel -= $this->movimentoLotes()->where('operacao', OperacaoMovimentoLote::Diminui)->sum('quantidade');

                $this->quantidade_total = $this->movimentoLotes()->where('operacao', OperacaoMovimentoLote::Soma)->sum('quantidade');

                $this->save();
            } finally {
                DB::raw('unlock tables');
            }
        });
    }
}
