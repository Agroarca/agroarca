<?php

namespace App\View\Components\Site\Carrinho;

use Illuminate\View\Component;

class Carrinho extends Component
{
    public $carrinho;
    public function __construct($carrinho)
    {

        $this->carrinho = json_encode($carrinho);
    }

    public function render()
    {
        return view('components.site.carrinho.carrinho');
    }
}
