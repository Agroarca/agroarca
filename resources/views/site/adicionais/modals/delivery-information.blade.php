<x-site.modal :title="'Como deseja sua entrega?'" :id="'delivery-info-modal'">
    <form onsubmit="preventDefault();" id="form-delivery-info">
        <div class="row">
            <div class="input-group mb-3">
                {{-- @TODO: Implementar inputmask --}}
                <span class="input-group-text" id="inputGroupCep">CEP</span>
                <input type="text" class="form-control" id="cep" name="cep" aria-describedby="inputGroupCep" required>
            </div>
            <div class="input-group">
                <span class="input-group-text" id="inputGroupDate">Data de Entrega</span>
                <input type="date" class="form-control" id="delivery-date" name="deliveryDate" aria-describedby="inputGroupDate" required>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" id="submit-delivery-form" class="btn btn-primary">Salvar</button>
    </x-slot>
</x-site.modal>

