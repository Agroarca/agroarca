@php
    use \App\Enums\Cadastros\Usuarios\TipoPessoaEnum;
@endphp

<x-admin>
    <x-slot name='header'>
        <div class="row">
            <div class="col-sm-8">
                <h1>Usuário {{ $usuario->nome }}</h1>
            </div>
            <div class="col-sm-4 pt-3 pt-sm-0">
                <a href="{{ route('admin.cadastros.usuarios.admin', $usuario->id) }}" class="btn btn-danger float-sm-right"><i class="fas fa-plus-circle pr-1"></i>
                    @if ($usuario->admin)
                        Remover Administrador
                    @else
                        Adicionar Administrador
                    @endif
                </a>
            </div>
        </div>
    </x-slot>

    <div class="card card-default">
        <form>
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">{{ $usuario->tipo_pessoa == TipoPessoaEnum::PessoaJuridica ? "Razão Social" : "Nome" }}:</label>
                    <input type="text" name="nome" class="form-control" value="{{ $usuario->nome }}" disabled />
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="text" name="email" class="form-control" value="{{ $usuario->email }}" disabled />
                </div>
                <div class="form-group">
                    <label for="data_verificacao_email">Data de Verificação do E-mail:</label>
                    <input type="text" name="data_verificacao_email" class="form-control" value="{{ $usuario->data_verificacao_email }}" disabled />
                </div>
                <div class="form-group">
                    <label for="tipo_pessoa">Tipo de Pessoa:</label>
                    <input type="text" name="tipo_pessoa" class="form-control" value="{{ $usuario->nomeTipoPessoa }}" disabled />
                </div>
                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" class="form-control" value="{{ $usuario->cpf }}" disabled />
                </div>
                <div class="form-group">
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" name="cnpj" class="form-control" value="{{ $usuario->cnpj }}" disabled />
                </div>
                <div class="form-group">
                    <label for="celular">Celular:</label>
                    <input type="text" name="celular" class="form-control" value="{{ $usuario->celular }}" disabled />
                </div>
               {{--  <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" name="status" class="form-control" value="{{ $usuario->status }}" disabled />
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo:</label>
                    <input type="text" name="tipo" class="form-control" value="{{ $usuario->tipo }}" disabled />
                </div> --}}
            </div>
        </form>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h2 class="card-title">Endereços do Usuário</h2>
            <div class="card-tools">
                <a href="{{ route('admin.cadastros.usuarios.enderecos.criar', $usuario->id) }}" class="btn btn-primary float-sm-right"><i class="fas fa-plus-circle pr-1"></i>Novo Endereço</a>
            </div>
        </div>
        <div class="card-body table-responsive">
            @include('admin.cadastros.usuarios.enderecos.listar', ['enderecos' => $usuario->enderecos, 'usuario' => $usuario])
        </div>
    </div>
</x-admin>
