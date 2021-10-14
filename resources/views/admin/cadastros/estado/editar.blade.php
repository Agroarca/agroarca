@section('InputMask', true)

<x-admin>
    <x-slot name='header'>
        <h1>Estado {{ $estado->nome }}</h1>
    </x-slot>
    <div class="card card-default">
        <form>
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" class="form-control" value="{{ $estado->nome }}" disabled />
                </div>
                <div class="form-group">
                    <label for="nome">UF:</label>
                    <input type="text" name="uf" class="form-control" value="{{ $estado->uf }}" disabled />
                </div>
                <div class="form-group">
                    <label for="icms">ICMS:</label>
                    <div class="input-group">
                        <input type="text" name="uf" class="form-control mask-percentual" value="{{ $estado->icms }}" />
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
</x-admin>
