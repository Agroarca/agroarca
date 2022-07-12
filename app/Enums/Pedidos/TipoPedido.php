<?php

namespace App\Enums\Pedidos;

use App\Enums\Enum;

class TipoPedido extends Enum
{
    const VendaEcommerce = 0;
    const Compra = 1;
    const VendaInterna = 2;

    public static $customNames = [
        self::VendaEcommerce => 'Venda E-Commerce',
        self::Compra => 'Compra',
        self::VendaInterna => 'Venda Interna',
    ];

    public static function getName($value)
    {
        return self::$customNames[$value];
    }

    public static function asArray()
    {
        return self::$customNames;
    }
}
