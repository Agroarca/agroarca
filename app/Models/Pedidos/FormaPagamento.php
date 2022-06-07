<?php

namespace App\Models\Pedidos;

use App\Traits\Dominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    use HasFactory, Dominio;

    protected $table = 'formas_pagamento';
    protected $fillable = [
        'nome',
        'tipo',
        'modalidade'
    ];
}
