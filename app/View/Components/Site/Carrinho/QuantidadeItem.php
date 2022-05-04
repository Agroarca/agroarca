<?php

namespace App\View\Components\Site\Carrinho;

use Illuminate\View\Component;

class QuantidadeItem extends Component
{
    public $name;
    public $value;
    public function __construct($name, $value = 1)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.site.carrinho.quantidade-item');
    }
}
