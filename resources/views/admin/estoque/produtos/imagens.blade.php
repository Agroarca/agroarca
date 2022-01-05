@section('CropperJS', true)

<form action="{{ route('admin.estoque.produtos.imagens.upload', $produto->id) }}" method="POST" enctype="multipart/form-data">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Adicionar Imagem</h3>
        </div>
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <input type="text" name="descricao" value="{{ old('descricao') }}" @class([
                    'form-control',
                    'is-invalid' => $errors->has('descricao'),
                ]) />
                <x-admin.form-error property='descricao'></x-admin.form-error>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem:</label>
                <input class="form-control-file crop-image-upload" type="file" id="imagem" name="imagem">
                <x-admin.form-error property='imagem'></x-admin.form-error>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </div>
</form>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Imagens do Produto</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @forelse ($produto->imagens as $imagem)
                <div class="col-md-12 col-lg-6 col-xl-4 mb-3">
                    <img class="card-img-top" src="{{ asset("storage/produtos/$imagem->nome_arquivo") }}">
                    <p>{{ $imagem->descricao }}</p>
                    <a href="{{ route('admin.estoque.produtos.imagens.delete', [$produto->id, $imagem->id]) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Excluir">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p>Nenhuma imagem adicionada</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="modal fade show crop-modal" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Imagem</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="crop-image-container">
                    <img src="" class="crop-image" />
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary crop-save">Salvar Imagem</button>
            </div>
        </div>
    </div>
</div>

