<?php

namespace App\Console\Commands;

use App\Enums\Cadastros\Usuarios\TipoPessoaEnum;
use App\Enums\Cadastros\Usuarios\TipoUsuarioEnum;
use App\Models\Cadastros\Usuario;
use App\Rules\CNPJ;
use App\Rules\CPF;
use App\Rules\Telefone;
use App\Rules\UniqueDominio;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateAdmin extends Command
{
    protected $signature = 'create:admin';
    protected $description = 'Cria um usuário como administrador';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $usuario = new Usuario();

        $usuario->nome = $this->ask("Nome Completo");

        $usuario->email = $this->ask("E-mail");

        $usuario->password = $this->secret("Senha");

        $usuario->tipo_pessoa = $this->choice("Tipo Pessoa", ['Física', 'Jurídica'], 0);

        if ($usuario->tipo_pessoa == 'Física') {
            $usuario->tipo_pessoa = TipoPessoaEnum::PessoaFisica;
            $usuario->cpf = $this->ask("CPF");
        } else {
            $usuario->tipo_pessoa = TipoPessoaEnum::PessoaJuridica;
            $usuario->cnpj = $this->ask("CNPJ");
        }

        $usuario->celular = $this->ask("Celular");

        $usuario->celular = preg_replace('/\D/', '', $usuario->celular);
        $usuario->cpf = preg_replace('/\D/', '', $usuario->cpf);
        $usuario->cnpj = preg_replace('/\D/', '', $usuario->cnpj);

        $validator = Validator::make(
            [
                'nome' => $usuario->nome,
                'email' => $usuario->email,
                'password' => $usuario->password,
                'celular' => $usuario->celular,
                'cpf' => $usuario->cpf,
                'cnpj' => $usuario->cnpj
            ],
            [
                'nome' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', new UniqueDominio('usuarios')],
                'password' => ['required', Password::defaults()],
                'celular' => ['bail', 'required', new Telefone()],
                'cpf' => ['bail', "required_if:tipo_pessoa," . TipoPessoaEnum::PessoaFisica, 'nullable', new CPF(), new UniqueDominio('usuarios')],
                'cnpj' => ['bail', "required_if:tipo_pessoa," . TipoPessoaEnum::PessoaJuridica, 'nullable', new CNPJ(), new UniqueDominio('usuarios')],
            ],
            [],
            [
                'nome' => 'Nome',
                'email' => 'E-mail',
                'password' => 'Senha',
                'cpf_cnpj' => 'Cpf ou Cnpj',
                'celular' => 'Celular',
                'cpf' => 'CPF',
                'cnpj' => 'CNPJ'
            ]
        );

        if ($validator->fails()) {
            $this->error("Ocorreu um erro ao criar o usuário:");
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        }

        $usuario->tipo = TipoUsuarioEnum::Admin;
        $usuario->password = Hash::make($usuario->password);
        $usuario->save();
        event(new Registered($usuario));
        $this->info("Usuario criado com sucesso");
    }
}
