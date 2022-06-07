<?php

namespace App\Enums\Pedidos;

use App\Enums\Enum;

class TipoFormaPagamento extends Enum
{
    const Manual = 0;


    public static $customNames = [
        self::Manual => 'Manual',
    ];

    public static function getName($value)
    {
        return self::$customNames[$value];
    }
}
