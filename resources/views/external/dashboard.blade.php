@extends('template.app-template-veris')
@section('title')
Veris - Facturas
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0" style="background-color: #e4e5e6;">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">Portal de Facturas Electrónicas</h5>
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="container-fluid my-3">
            <div class="row">
                <div class="col-12">
                    <div class="accordion" id="accordionExample">
                        <div class="card accordion-item active">
                            <h2 class="accordion-header" id="headingOne">
                                <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter me-2" width="17" height="17" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z"></path>
                                    </svg>
                                    Filtros de búsqueda
                                </button>
                            </h2>
                            <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <form class="accordion-body" action="" method="GET">
                                    <div class="row g-3">
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <label for="fecha" class="form-label">Fecha</label>
                                            <input type="text" class="form-control flatpickr-input active" placeholder="Rango de fecha" id="fecha" readonly="readonly">
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <label for="tipoComprobante" class="form-label">Tipo de comprobante</label>
                                            <select id="tipoComprobante" name="tipoComprobante" class="form-select select2 w-100" data-style="btn-default">
                                                {{-- <option value="" disabled selected>Selecciona una opción</option> --}}
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <label for="codigoCliente" class="form-label">Nro. Comprobante</label>
                                            <input type="number"
                                                inputmode="numeric" 
                                                pattern="[0-9]*"
                                                step="1"
                                                class="form-control"
                                                id="codigoCliente"
                                                name="codigoCliente" 
                                                placeholder="" />
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <label for="numeroDocumento" class="form-label">Nro. Cédula/Ruc</label>
                                            <input type="text"
                                                class="form-control"
                                                id="numeroDocumento"
                                                name="numeroDocumento" 
                                                placeholder="" />
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <label for="sucursal" class="form-label">Sucursal</label>
                                            <select id="sucursal" name="sucursal" class="form-select select2 w-100" data-style="btn-default">
                                                {{-- <option value="" disabled selected>Selecciona una opción</option> --}}
                                            </select>
                                        </div>
                                        <div class="col-10 col-sm-5 col-md-3">
                                            <button style="height: 37.6px;" type="submit" class="btn bg-veris-ai w-100 mt-0 mt-sm-4 text-white">Buscar</button>
                                        </div>
                                        <div class="col-2 col-sm-1 col-md-1">
                                            <a href="{{ request()->url() }}" type="button" class="btn bg-alt w-100 mt-0 mt-sm-4" title="Limpiar Filtro">
                                                <img class="ico-button" src="{{ asset('assets/img/veris/reset-ico.svg') }}">
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nro. Comprobante</th>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Nro. Documento</th>
                                            <th>Sucursal</th>
                                            <th>Archivos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>001-102-002013686</td>
                                            <td>2026-06-05 00:00:00</td>
                                            <td>Factura</td>
                                            <td>0923796304001</td>
                                            <td>Mall del Sol</td>
                                            <td>
                                                <div class="w-100 d-flex justify-content-start align-items-center gap-2">
                                                    <i class="fa-solid fa-file-excel"></i>
                                                    <i class="fa-solid fa-file-pdf pdf-view"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>001-102-002013686</td>
                                            <td>2026-06-05 00:00:00</td>
                                            <td>Factura</td>
                                            <td>0923796304001</td>
                                            <td>Mall del Sol</td>
                                            <td>
                                                <div class="w-100 d-flex justify-content-start align-items-center gap-2">
                                                    <i class="fa-solid fa-file-excel"></i>
                                                    <i class="fa-solid fa-file-pdf pdf-view"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>001-102-002013686</td>
                                            <td>2026-06-05 00:00:00</td>
                                            <td>Factura</td>
                                            <td>0923796304001</td>
                                            <td>Mall del Sol</td>
                                            <td>
                                                <div class="w-100 d-flex justify-content-start align-items-center gap-2">
                                                    <i class="fa-solid fa-file-excel"></i>
                                                    <i class="fa-solid fa-file-pdf pdf-view"></i>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="card-footer">
                    {{-- @include('partials.pagination') --}}
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modalPDF" tabindex="-1" aria-labelledby="modalPDFLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered"> <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mb-2" id="modalPDFLabel">Visualizador de Documento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0" style="height: 75vh;">
            <div id="contenedorPDF" class="w-100 h-100">
                <iframe class="w-100 h-100" src="assets/034-100-001003623.pdf#toolbar=0&navpanes=0&statusbar=0" frameborder="0"></iframe>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary-veris text-veris-ai" data-bs-dismiss="modal">Cerrar</button>
            <a id="btnDescargarPDF" href="#" download class="btn bg-veris-ai text-white">
                <i class="bi bi-download me-2"></i> Descargar PDF
            </a>
        </div>
    </div>
</div>
</div>
@endsection
@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", async function () {
        inicializarDatePickers();

        $('body').on('click', '.pdf-view', function(){
            $('#modalPDF').modal('show');
        })
    })

    // 1. Instanciamos el modal de Bootstrap 5
    const miModalPDF = new bootstrap.Modal(document.getElementById('modalPDF'));

    // 2. Función que debes llamar desde tu evento (un botón, una fila de tabla, etc.)
    function abrirVisorPDF(urlPdf, nombreDescarga = "documento.pdf") {
        const contenedor = document.getElementById('contenedorPDF');
        const btnDescargar = document.getElementById('btnDescargarPDF');

        // Limpiamos el contenedor por si había un PDF abierto antes
        contenedor.innerHTML = '';

        // Creamos la etiqueta <embed> dinámicamente
        const elementoEmbed = document.createElement('embed');
        elementoEmbed.src = urlPdf;
        elementoEmbed.type = "application/pdf";
        elementoEmbed.className = "w-100 h-100"; // Clases de Bootstrap para ocupar todo el espacio

        // Insertamos el PDF en el cuerpo del modal
        contenedor.appendChild(elementoEmbed);

        // Configuramos el botón de descarga externa
        btnDescargar.href = urlPdf;
        btnDescargar.setAttribute('download', nombreDescarga); // Fuerza el nombre del archivo al descargar

        // Finalmente, abrimos el modal
        miModalPDF.show();
    }
</script>

@endpush