<?php

namespace App\Enums\Pedidos;

use App\Enums\Enum;

class StatusPedido extends Enum
{
    const Aberto = 0;
    const Analise = 1;
    const Aprovado = 2;
    const Finalizado = 3;
    const Cancelado = 4;
}
