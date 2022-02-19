<?php

namespace App\Services\Site;

use App\Models\Cadastros\UsuarioEndereco;
use App\Models\Frete\Cep;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class EntregaService
{

    public static function getCepEnderecoPadrao()
    {
        //se usuario está logado e possui um endereço padrão
        $endereco_id = request()->cookie('endereco_padrao_id');
        if ($endereco_id && Auth::check()) {
            $endereco = UsuarioEndereco::where('usuario_id', Auth::id())->find($endereco_id);
            if ($endereco) {
                return $endereco;
            }
        }

        //se usuario possui um cep padrão
        $cep = request()->cookie('cep');
        if ($cep) {
            if (Auth::check()) {
                $endereco = Auth::user()->enderecos()->where('cep', $cep)->first();
                if ($endereco) {
                    //seta como endereço padrão
                    Cookie::queue('endereco_padrao_id', $endereco->id);
                    return $endereco;
                }
            }

            return Cep::firstOrCreate(['cep' => $cep]);
        }

        //se usuario está logado e não possui endereço ou CEP setado
        if (Auth::check()) {
            $endereco = Auth::user()->enderecos()->first();
            if ($endereco) {
                Cookie::queue('cep', $endereco->cep);
                Cookie::queue('endereco_padrao_id', $endereco->id);
                return $endereco;
            }
        }
    }

    public static function atualizarCepCookie($cep)
    {
        Cookie::queue('cep', $cep);
        Cookie::queue('endereco_padrao_id', null);
    }

    public static function getDataEntrega()
    {
        return Carbon::now()->addDays(15)->toDateTimeLocalString();;
    }
}
