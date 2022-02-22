<style>

    #delivery-info-modal .input-group-text{
        width: 40%;
        display: block;
        text-align: center;
    }
</style>

{{-- @TODO: Falta estilizar modal conforme layout modelo figma. --}}

{{--
    Pensar em alguma forma de componentizar o modal, para um layout base.

    https://www.figma.com/file/OIUAXTc9iZXZLAwndWiLFs/AgroArca---Pilati---Mobile-KIT-UI---Entrega?node-id=0%3A1
    --}}
<div class="modal" tabindex="-1" id="delivery-info-modal">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Como deseja sua entrega?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

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

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="button" id="submit-delivery-form" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>
