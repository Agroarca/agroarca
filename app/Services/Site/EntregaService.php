<?php

namespace App\Services\Site;

use App\Models\Cadastros\UsuarioEndereco;
use App\Models\Frete\Cep;
use App\Models\Pedidos\ItemListaPreco;
use App\Services\DistanciasService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EntregaService
{

    public static function getCepEnderecoPadrao()
    {
        $enderecoId = session('endereco_padrao_id', null);
        if ($enderecoId) {
            $endereco = UsuarioEndereco::where('usuario_id', Auth::id())->find($enderecoId);
            if ($endereco) {
                return $endereco;
            }
        }

        //se usuario possui um cep padrão
        $cep = session('cep', null);
        if ($cep) {
            return Cep::firstOrCreate(['cep' => $cep]);
        }

        //se usuario está logado e não possui endereço ou CEP setado
        if (Auth::check()) {
            $endereco = UsuarioService::retornarEnderecoPadrao();
            if ($endereco) {
                self::atualizarCepEnderecoPadrao($endereco);
                return $endereco;
            }
        }
    }

    public static function atualizarCepEnderecoPadrao($param)
    {
        request()->session()->forget(['endereco_padrao_id', 'cep']);
        if ($param instanceof UsuarioEndereco) {
            session(['endereco_padrao_id' => $param->id]);
            session(['cep' => $param->cep]);
            return;
        }

        if ($param instanceof Cep) {
            session(['cep' => $param->cep]);
            return;
        }

        if (Auth::check()) {
            $endereco = Auth::user()->enderecos()->where('cep', $param)->first();
            if ($endereco) {
                session(['endereco_padrao_id' => $param->id]);
                session(['cep' => $param->cep]);
                return;
            }
        }

        session(['cep' => $param]);
    }

    public static function calcularFrete(ItemListaPreco $item, $cep)
    {
        $distancia = DistanciasService::calcularDistancia($cep, $item->centroDistribuicao);
        return $item->base_frete * ($distancia / 1000);
    }

    public static function verificarEnderecoLogin()
    {
        $endereco = self::getCepEnderecoPadrao();

        if (!($endereco instanceof Cep)) {
            return;
        }

        $enderecoUsuario = UsuarioEndereco::where('usuario_id', Auth::id())->where('cep', $endereco->cep)->first();
        if (is_null($enderecoUsuario)) {
            return;
        }

        $pedido = PedidoService::getPedido();
        $pedido->endereco_id = $enderecoUsuario->id;
        $pedido->save();
    }
}
