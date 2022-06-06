<?php

namespace App\Services\Site;

use App\Models\Cadastros\Usuario;
use App\Models\Cadastros\UsuarioEndereco;
use Illuminate\Support\Facades\Auth;

class UsuarioService
{
    public static function verificarEnderecoPadrao($usuarioId = null)
    {
        if (is_null($usuarioId)) {
            $usuarioId = Auth::id();
        }

        $padrao = UsuarioEndereco::where('usuario_id', $usuarioId)->where('padrao', true)->first();
        if ($padrao) {
            return;
        }

        $endereco = UsuarioEndereco::where('usuario_id', $usuarioId)->orderBy('updated_at', 'desc')->first();

        $endereco->padrao = true;
        $endereco->save();
    }

    public static function selecionarEnderecoPadrao(UsuarioEndereco $endereco, $usuarioId = null)
    {
        if (is_null($usuarioId)) {
            $usuarioId = Auth::id();
        }

        UsuarioEndereco::where('usuario_id', $usuarioId)->update(['padrao' => false]);
        $endereco->padrao = true;
        $endereco->save();
    }

    public static function retornarEnderecoPadrao($usuarioId = null)
    {
        if (is_null($usuarioId)) {
            if (!Auth::check()) {
                return;
            }

            $usuarioId = Auth::id();
        }

        return UsuarioEndereco::where('usuario_id', $usuarioId)->where('padrao', true)->first();
    }
}
