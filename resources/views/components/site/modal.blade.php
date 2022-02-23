<div @class($class) {{ $id ? "id={$id}" : ''}}  {{ $attributes }}>
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}
                    <span class="modal-title-meta"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                {{ $footer }}
            </div>
        </div>
    </div>
</div>
