<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\UsuarioEndereco;
use App\Models\Frete\Cep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class FreteController extends Controller
{
    public function getCepEnderecoPadrao(){

        //se usuario está logado e possui um endereço padrão
        $endereco_id = request()->cookie('endereco_padrao_id');
        if($endereco_id && Auth::check()){
            $endereco = UsuarioEndereco::where('usuario_id', Auth::id())->find($endereco_id);
            if($endereco){
                return $endereco;
            }
        }

        //se usuario possui um cep padrão
        $cep = request()->cookie('cep');
        if($cep){
            if(Auth::check()){
                $endereco = Auth::user()->enderecos()->where('cep', $cep)->first();
                if($endereco){
                    //seta como endereço padrão
                    Cookie::queue('endereco_padrao_id', $endereco->id);
                    return $endereco;
                }
            }

            return Cep::firstOrCreate(['cep' => $cep]);
        }

        //se usuario está logado e não possui endereço ou CEP setado
        if(Auth::check()){
            $endereco = Auth::user()->enderecos()->first();
            if($endereco){
                Cookie::queue('cep', $endereco->cep);
                Cookie::queue('endereco_padrao_id', $endereco->id);
                return $endereco;
            }
        }
    }

    public function atualizarCep(Request $request){
        $cep = $request->input('cep') ?? $request->query('cep');
        Cookie::queue('cep', $cep);
        Cookie::queue('endereco_padrao_id', null);
    }
}
