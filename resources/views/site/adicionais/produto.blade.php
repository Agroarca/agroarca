<div class="produto-adicional">

    <p><input type="checkbox" name="adicional[]" value="{{ $produto->itensListaPreco->first()->id }}" {{ in_array($produto->itensListaPreco->first()->id, old('adicional') ?? []) ? 'checked' : '' }} @class(['form-check-input', 'is-invalid' => $errors->has("adicional-$produto->id")]) /></p>
    <p>Cod: {{ $produto->codigo }}</p>
    <p>Produto: {{ $produto->nome }}</p>
    <p>preco: {{ $produto->itensListaPreco->first()->preco_quilo }}</p>
</div>
