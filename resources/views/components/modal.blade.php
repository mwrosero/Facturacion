<!-- resources/views/components/modal.blade.php -->
@props(['id' => 'modalAlert', 'title' => 'Título', 'message' => ''])

<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-alert-component modal-dialog-centered mx-auto" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto title-section text-veris fw-medium" id="modalAlertTitle">{{ $title }}</h5>
            </div>
            <div class="modal-body text-center fs-14 mb-2" id="modalAlertMessage">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <a href="#" type="button" class="btn bg-veris fs--18 line-height-24 w-100 m-0 fw-medium d-none mb-3" id="modalAlertButtonAccion"></a>
                <button type="button" class="btn fs--18 line-height-24 w-100 m-0 fw-medium shadow-none border-0 d-none" data-bs-dismiss="modal" id="modalAlertButtonCancelar">Cancelar</button>
                <button type="button" class="btn bg-veris fs--18 line-height-24 w-100 m-0 fw-medium" data-bs-dismiss="modal" id="modalAlertButton">Aceptar</button>
            </div>
        </div>
    </div>
</div>