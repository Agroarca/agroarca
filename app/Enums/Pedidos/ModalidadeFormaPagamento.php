<?php

namespace App\Enums\Pedidos;

use App\Enums\Enum;

class ModalidadeFormaPagamento extends Enum
{
    const AVista = 0;
    const Credito = 1;

    public static $customNames = [
        self::AVista => 'À Vista',
        self::Credito => 'Crédito',
    ];

    public static function getName($value)
    {
        return self::$customNames[$value];
    }
}
