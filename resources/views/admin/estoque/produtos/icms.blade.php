@php
    use \App\Models\Cadastros\Estado;
@endphp

<div class="card card-default collapsed-card">
    <div class="card-header">
        <h3 class="card-title">ICMS</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.estoque.produtos.icms.atualizar', $produto->id) }}" method="POST">
            @csrf
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">ICMS Padrão</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="icms_padrao"  data-toggle="tooltip" data-placement="top" title="ICMS padrão que deve ser considerado para todos os estados"><i class="fas fa-info-circle"></i> ICMS Padrão (%):</label>
                        <input type="text" name="icms_padrao" value="{{ $produto->icms_padrao }}" @class(['form-control mask-percentual', 'is-invalid' => $errors->has('icms_padrao')]) />
                        <x-admin.form-error property='icms_padrao'></x-admin.form-error>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </div>
        </form>

        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Exceções ICMS</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-stripped table-hover table-bordered">
                    <thead>
                        <th>Estado</th>
                        <th>ICMS</th>
                        <th>Açoes</th>
                    </thead>
                    <tbody>
                        @foreach ($produto->icmsEstado as $icms)
                            <tr>
                                <td>{{ $icms->estado->uf }}</td>
                                <td>{{ $icms->icms }}</td>
                                <td>
                                    <a href="{{ route('admin.estoque.produtos.icms.excluir', [$produto->id, $icms->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Excluir">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <form action="{{ route('admin.estoque.produtos.icms.adicionar', $produto->id) }}" method="POST">
            @csrf
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Adicionar Exceção ICMS</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="icms"  data-toggle="tooltip" data-placement="top" title="ICMS padrão que deve ser considerado para todos os estados"><i class="fas fa-info-circle"></i> ICMS Padrão (%):</label>
                        <input type="text" name="icms" value="{{ $produto->icms }}" @class(['form-control mask-percentual', 'is-invalid' => $errors->has('icms')]) />
                        <x-admin.form-error property='icms'></x-admin.form-error>
                    </div>

                    <div class="form-group">
                        <label for="estado_id">Estado:</label>
                        <x-admin.select name='estado_id' :values="Estado::selectTodos()" :selected="old('estado_id')" placeholder="Selecione um Estado" :class="['form-control', 'is-invalid' => $errors->has('estado_id')]"></x-admin.select>
                        <x-admin.form-error property='estado_id'></x-admin.form-error>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>
