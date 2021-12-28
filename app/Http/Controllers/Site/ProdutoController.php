<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frete\DistanciasController;
use App\Models\Cadastros\UsuarioEndereco;
use App\Models\Estoque\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function produto($id){
        $produto = Produto::findOrFail($id);
        $this->teste();
        return view('site.produto.produto', compact('produto'));
    }

    public function teste(){
        $controller = new DistanciasController();
        $cep = $controller->criarCep('99010051');

        $enderecos = UsuarioEndereco::all();
        $controller->calcularDistancia($cep, $enderecos[0]);
        $controller->calcularDistancia($enderecos[1], $enderecos[0]);
    }
}
