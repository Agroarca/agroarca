<?php

namespace App\Http\Controllers\Site;

use App\Enums\Cadastros\Usuarios\TipoPessoaEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastros\UsuarioEnderecoRequest;
use App\Http\Requests\Site\Perfil\AtualizarUsuarioRequest;
use App\Models\Cadastros\Usuario;
use App\Models\Cadastros\UsuarioEndereco;
use App\Services\Site\UsuarioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function inicio()
    {
        $usuario = Auth::user();
        return view('site.perfil.inicio', compact('usuario'));
    }

    public function atualizar(AtualizarUsuarioRequest $request)
    {
        $usuario = Usuario::find(Auth::id());
        $usuario->update($request->only(['nome', 'email', 'cpf', 'cnpj', 'celular', 'tipo_pessoa']));

        if ($usuario->tipo_pessoa == TipoPessoaEnum::PessoaJuridica) {
            $usuario->cpf = null;
        } else {
            $usuario->cnpj = null;
        }

        if (!is_null($request->has('password'))) {
            $usuario->password = Hash::make($request->password);
            $usuario->save();
        }

        Auth::login($usuario);
        return redirect()->route('site.perfil');
    }

    public function adicionarEndereco()
    {
        return view('site.perfil.endereco');
    }

    public function salvarEndereco(UsuarioEnderecoRequest $request)
    {
        $endereco = new UsuarioEndereco($request->all());
        $endereco->usuario_id = Auth::id();
        $endereco->save();

        UsuarioService::verificarEnderecoPadrao();
        return redirect()->route('site.perfil');
    }

    public function excluirEndereco($id)
    {
        UsuarioEndereco::where('usuario_id', Auth::id())->find($id)->delete();

        UsuarioService::verificarEnderecoPadrao();
        return redirect()->route('site.perfil');
    }

    public function selecionarPadrao($id)
    {
        $endereco = UsuarioEndereco::where('usuario_id', Auth::id())->findOrFail($id);
        UsuarioService::selecionarEnderecoPadrao($endereco);
        return redirect()->route('site.perfil');
    }
}
