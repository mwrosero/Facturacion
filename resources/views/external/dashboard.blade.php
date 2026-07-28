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
                    <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">Portal Facturas Electrónicas</h5>
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
                                <div class="accordion-body">
                                    <div class="row g-3 justify-content-end">
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <label for="fecha" class="form-label">Fecha</label>
                                            <input type="text" class="form-control flatpickr-input active" placeholder="Rango de fecha" id="fecha" readonly="readonly" style="height: 37.6px;">
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <label for="tipoComprobante" class="form-label">Tipo de comprobante</label>
                                            <select id="tipoComprobante" name="tipoComprobante" class="form-select select2 w-100" data-style="btn-default">
                                                <option value="">Todos</option>
                                                <option value="F">Factura</option>
                                                <option value="NC">Nota de Crédito</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <label for="numeroComprobante" class="form-label">Nro. Comprobante</label>
                                            <input type="text"
                                                inputmode="numeric" 
                                                pattern="[0-9]{3}-[0-9]{3}-[0-9]{9}"
                                                maxlength="17"
                                                class="form-control"
                                                id="numeroComprobante"
                                                name="numeroComprobante" 
                                                placeholder="000-000-000000000" />
                                        </div>
                                        @if (!Session::has('user_external'))
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
                                                <option value="">Todas</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <label for="estado" class="form-label">Estado</label>
                                            <select id="estado" name="estado" class="form-select select2 w-100" data-style="btn-default">
                                                <option value="">Todos</option>
                                                <option value="A">Autorizados</option>
                                                <option value="N">No Autorizados</option>
                                                <option value="R">Recibidos</option>
                                                <option value="D">Devueltos</option>
                                            </select>
                                        </div>
                                        @endif
                                        <div class="col-10 col-sm-5 col-md-3">
                                            <button style="height: 37.6px;" class="btn bg-veris-ai w-100 mt-0 mt-sm-4 text-white" title="Buscar comprobantes" id="btn-buscar">Buscar</button>
                                        </div>
                                        <div class="col-2 col-sm-1 col-md-1">
                                            <a href="{{ request()->url() }}" type="button" class="btn bg-alt w-100 mt-0 mt-sm-4" title="Limpiar Filtro">
                                                <img class="ico-button" src="{{ asset('assets/img/veris/reset-ico.svg') }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
                                            <th>Fecha Emisión</th>
                                            <th>Fecha Autorización</th>
                                            <th>Tipo</th>
                                            <th>Total</th>
                                            @if (!Session::has('user_external'))
                                            <th>Nro. Documento</th>
                                            <th>Estado</th>
                                            <th>Sucursal</th>
                                            @endif
                                            <th>Archivos</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listado-comprobantes">
                                        {{-- <tr>
                                            <td>001-102-002013686</td>
                                            <td>2026-06-05 00:00:00</td>
                                            <td>Factura</td>
                                            <td>0923796304001</td>
                                            <td>Mall del Sol</td>
                                            <td>
                                                <div class="w-100 d-flex justify-content-start align-items-center gap-2">
                                                    <i class="fa-solid fa-file-excel"></i>
                                                    <i class="fa-solid fa-file-pdf pdf-view d-none d-md-block"></i>
                                                    <i class="fa-solid fa-file-pdf d-block d-md-none"></i>
                                                </div>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                            <nav class="pt-4 mt-3 d-none" aria-label="Page navigation">
                                <ul class="pagination justify-content-center" id="lista-paginacion">
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modalPDF" tabindex="-1" aria-labelledby="modalPDFLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-2" id="modalPDFLabel">Visualizador de Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="height: 75vh;">
                <div id="contenedorPDF" class="w-100 h-100">
                    {{-- <iframe class="w-100 h-100" src="assets/034-100-001003623.pdf#toolbar=0&navpanes=0&statusbar=0" frameborder="0"></iframe> --}}
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
    let page = 1;
    let perPage = 10;
    document.addEventListener("DOMContentLoaded", async function () {
        inicializarDatePickers();
        await obtenerTiposComprobante();
        @if (!Session::has('user_external'))
        await obtenerSucursales();
        @endif

        $('body').on('click', '.pdf-view', function(){
            $('#modalPDF').modal('show');
        })

        $('body').on('click', '#btn-buscar', async function(){
            page = 1;
            await obtenerComprobantes()
        })

        $('body').on('click', '.btn-navigation', async function(){
            page = parseInt(jQuery(this).attr('page-rel'))
            await obtenerComprobantes();
        })

        $('body').on('click', '.file-view', async function(){
            let type = $(this).attr('type-rel');
            let comprobante = JSON.parse($(this).parent().attr('data-rel'));
            await cargarDocumento(comprobante, type);
        });

        $('#modalPDF').on('hidden.bs.modal', function () {
            // Obtenemos el enlace de descarga actual
            const $btnDescargar = $('#btnDescargarPDF');
            const pdfUrl = $btnDescargar.attr('href');

            // Si existe una URL de tipo blob, la liberamos
            if (pdfUrl && pdfUrl.startsWith('blob:')) {
                URL.revokeObjectURL(pdfUrl);
            }

            // Limpiamos el iframe y reseteamos el botón para el siguiente documento
            $('#contenedorPDF').empty();
            $btnDescargar.attr('href', '#').removeAttr('download');
        });

    })

    async function cargarDocumento(comprobante, type){
        let args = [];        
        args["endpoint"] = `${api_url}/${api_war}/v1/comprobantes/generarArchivo?numeroComprobante=${comprobante.numeroComprobante}&tipoDocumento=${comprobante.tipoDocumento}&tipoArchivo=${type}`;
        args["method"] = "GET";
        @if (Session::has('user_external'))
        args["codigoUsuarioPortal"] = "{{ $codigoUsuarioPortal }}";
        args["tokenPortalUsuario"] = "{{ $tokenPortalUsuario }}";
        args["token"] = "{{ $accessToken }}";
        @else
        args["token"] = "{{ Session::get('accessToken') }}";
        @endif
        args["showLoader"] = true;
        
        console.log('args', args["endpoint"]);
        try {
            const blob = await callInformes(args);
            const pdfUrl = URL.createObjectURL(blob);
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            const nombreArchivo = `${comprobante.nombreTipoComprobante}-${comprobante.numeroComprobante}.${type.toLowerCase()}`;

            if (isMobile || type == "XML") {
                const link = document.createElement('a');
                link.href = pdfUrl;
                link.download = nombreArchivo;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                // En móviles liberamos después de un tiempo prudencial
                setTimeout(() => {
                    URL.revokeObjectURL(pdfUrl);
                }, 15000);
            } else {
                // 1. Creamos el iframe ocupando el 100% del contenedor del modal
                const $iframe = $('<iframe>', {
                    src: pdfUrl,
                    css: {
                        'width': '100%',
                        'height': '100%', // Cambiado a 100% para que use el alto del contenedor modal-body
                        'border': 'none'
                    }
                });

                $('#contenedorPDF').html($iframe);

                // 2. Configuramos el botón de descarga con la URL del Blob y el nombre correcto
                const $btnDescargar = $('#btnDescargarPDF');
                $btnDescargar.attr('href', pdfUrl);
                $btnDescargar.attr('download', nombreArchivo);

                // 3. Abrimos el modal
                $('#modalPDF').modal('show');
            }

        } catch (error) {
            console.error('Error al obtener el PDF:', error);
            showMessage('error', error.message || `No se pudo procesar la solicitud.`)
        }
    }

    document.getElementById('numeroComprobante').addEventListener('input', function (e) {
        let cursorPosition = this.selectionStart;
        let originalLength = this.value.length;

        // 1. Limpiar el valor: dejar solo los números
        let value = this.value.replace(/\D/g, '');
        let formatted = '';

        // 2. Construir la máscara dinámica (000-000-000000000)
        if (value.length > 0) {
            // Primer bloque (hasta 3 dígitos)
            formatted += value.substring(0, 3);
        }
        if (value.length > 3) {
            // Segundo bloque (hasta 3 dígitos)
            formatted += '-' + value.substring(3, 6);
        }
        if (value.length > 6) {
            // Tercer bloque (hasta 9 dígitos)
            formatted += '-' + value.substring(6, 15);
        }

        // 3. Asignar el valor formateado al input
        this.value = formatted;

        // 4. Ajustar la posición del cursor para que no salte al final si el usuario edita en el medio
        let lengthDifference = formatted.length - originalLength;
        this.setSelectionRange(cursorPosition + lengthDifference, cursorPosition + lengthDifference);
    });

    // Evitar que se borre el guión de golpe y deje un comportamiento extraño al presionar Backspace
    document.getElementById('numeroComprobante').addEventListener('keydown', function (e) {
        if (e.key === 'Backspace') {
            let cursor = this.selectionStart;
            // Si el usuario borra justo donde hay un guión, borramos el número anterior también
            if (this.value[cursor - 1] === '-') {
                e.preventDefault();
                let value = this.value;
                this.value = value.substring(0, cursor - 2) + value.substring(cursor);
                this.setSelectionRange(cursor - 2, cursor - 2);
                // Disparamos el evento input para recalcular la máscara
                this.dispatchEvent(new Event('input'));
            }
        }
    });

    async function obtenerSucursales(){
        let args = [];
        args["endpoint"] = `${api_url}/${api_war_general}/v1/sucursales?codigoEmpresa=1&tipoSucursal=TODOS&grupoSucursal=TODOS&mostrarSucursalPrioritaria=true`
        args["method"] = "GET";
        args["showLoader"] = false;
        @if (Session::has('user_external'))
        args["codigoUsuarioPortal"] = "{{ $codigoUsuarioPortal }}";
        args["tokenPortalUsuario"] = "{{ $tokenPortalUsuario }}";
        args["token"] = "{{ $accessToken }}";
        @else
        args["token"] = "{{ Session::get('accessToken') }}";
        @endif
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            {{-- let elem = `<option value="" disabled selected>Selecciona una opción</option>`; --}}
            let elem = `<option value="">Todas</option>`;
            $.each(data.data, function(key, value){
                elem += `<option value="${value.codigoSucursal}">${value.nombreSucursal}</option>`;
            })
            $('#sucursal').html(elem);
        }
    }

    async function obtenerTiposComprobante(){
        let args = [];
        args["endpoint"] = `${api_url}/${api_war_general}/v1/tipos_comprobantes?codigoEmpresa=1&estado=ACTIVO`
        args["method"] = "GET";
        args["showLoader"] = false;
        @if (Session::has('user_external'))
        args["codigoUsuarioPortal"] = "{{ $codigoUsuarioPortal }}";
        args["tokenPortalUsuario"] = "{{ $tokenPortalUsuario }}";
        args["token"] = "{{ $accessToken }}";
        @else
        args["token"] = "{{ Session::get('accessToken') }}";
        @endif
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            let elem = `<option value="" disabled selected>Todos</option>`;
            $.each(data.data, function(key, value){
                elem += `<option value="${value.codigoTipoComprobante}">${value.nombreTipoComprobante}</option>`;
            })
            $('#tipoComprobante').html(elem);
        }else{
            if(data.message == "Sesión de portal inválida o expirada." || data.message == "Error de autenticación: El token ha caducado o no es válido"){
                logoutSystem(data.message);
            }else{
                showMessage('error', data.message)
            }
        }
    }

    async function obtenerComprobantes(){
        $('#lista-paginacion').parent().addClass('d-none');
        let datoFecha = obtenerFechasFormateadas();
        let nombreTipoComprobante = $('#tipoComprobante option:selected').val();
        let numeroComprobante = $('#numeroComprobante').val();
        let url_param_add = ``;
        @if (!Session::has('user_external'))
            let sucursal = $('#sucursal option:selected').val();
            if(sucursal == "T"){
                url_param_add += `&codigoSucursal=${sucursal}`;
            }

            let numeroDocumento = $('#numeroDocumento').val();
            if(numeroDocumento !== ""){
                url_param_add += `&numeroIdentificacion=${numeroDocumento}`;
            }
            
            let estado = $('#estado option:selected').val();
            if(estado !== ""){
                url_param_add += `&estadoMensaje=${estado}`;
            }
        @endif
        let args = [];
        args["endpoint"] = `${api_url}/${api_war}/v1/comprobantes?fechaInicio=${datoFecha.fechaDesde}&fechaFin=${datoFecha.fechaHasta}&page=${page}&perPage=${perPage}&nombreTipoComprobante=${nombreTipoComprobante}&numeroComprobante=${numeroComprobante}${url_param_add}`;
        args["method"] = "GET";
        @if (Session::has('user_external'))
        args["codigoUsuarioPortal"] = "{{ $codigoUsuarioPortal }}";
        args["tokenPortalUsuario"] = "{{ $tokenPortalUsuario }}";
        args["token"] = "{{ $accessToken }}";
        @else
        _token = "{{ Session::get('accessToken') }}";
        @endif
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            drawComprobantes(data.data.rows, data.data.totalRows);
        }else{
            if(data.message == "Sesión de portal inválida o expirada." || data.message == "Error de autenticación: El token ha caducado o no es válido"){
                logoutSystem(data.message);
            }else{
                showMessage('error', data.message)
            }
        }
    }

    function drawComprobantes(rows, totalRows){
        let elem = ``;
        let colspanValue = "5";
        @if (!Session::has('user_external'))
            colspanValue = "7";
        @endif
        if(rows.length == 0){
            elem += `<tr>
                <td class="text-center" colspan="${colspanValue}">No existen comprobantes que mostrar.</td>
            </tr>`;
        }else{
            page++;
            $.each(rows, function(key, value){
                let td_interno = ``;
                @if (!Session::has('user_external'))
                    td_interno += `<td>${value.numeroIdentificacion}</td>
                        <td>${value.estadoMensaje}</td>
                        <td>${value.nombreSucursal}</td>`;
                @endif
                elem += `<tr>
                    <td>${value.numeroComprobante}</td>
                    <td>${ (value.fechaEmision !== null) ? (value.fechaEmision.split(" "))[0] : "" }</td>
                    <td>${ (value.fechaProcesado !== null) ? value.fechaProcesado : "" }</td>
                    <td>${value.nombreTipoComprobante}</td>
                    <td>$${value.valorTotal.toFixed(2)}</td>
                    ${td_interno}
                    <td>
                        <div class="w-100 d-flex justify-content-start align-items-center gap-2" data-rel='${JSON.stringify(value)}'>
                            <i class="fa-solid fa-file-excel file-view" type-rel="XML"></i>
                            <i class="fa-solid fa-file-pdf file-view" type-rel="PDF"></i>
                        </div>
                    </td>
                </tr>`;
            })
            drawPagination(totalRows, page-1);
        }

        $('#listado-comprobantes').html(elem);
    }

    async function drawPagination(cantidadItems, currentPage = 1){
        // console.log(currentPage)
        const totalPages = Math.ceil(cantidadItems / perPage);
        const page = Math.max(1, Math.min(currentPage, totalPages));

        const prevPage = page > 1 ? page - 1 : 1;
        const nextPage = page < totalPages ? page + 1 : totalPages;


        let elem = `<li class="page-item ${page === 1 ? 'disabled' : ''}">
                <div type="button" class="page-link border-0 btn-navigation" aria-label="First" type-rel="first" page-rel="1">
                    <i class="bi bi-chevron-double-left"></i>
                </div>
            </li>
            <li class="page-item" ${page === 1 ? 'disabled' : ''}>
                <div type="button" class="page-link btn-navigation border-0" aria-label="Previous" type-rel="previous" page-rel="${prevPage}">
                    <i class="bi bi-chevron-left"></i>
                </div>
            </li>
            <li class="page-item active"><div class="page-link border-0">${page}</div></li>
            <li class="page-item"><span class="page-link border-0">de</span></li>
            <li class="page-item"><div class="page-link border-0">${totalPages}</div></li>
            <li class="page-item ${page === totalPages ? 'disabled' : ''}">
                <div type="button" class="page-link btn-navigation border-0" aria-label="Next" type-rel="next" page-rel="${ nextPage }">
                    <i class="bi bi-chevron-right"></i>
                </div>
            </li>
            <li class="page-item ${page === totalPages ? 'disabled' : ''}">
                <div type="button" class="page-link btn-navigation border-0" aria-label="Last" type-rel="previous" page-rel="${ totalPages }">
                    <i class="bi bi-chevron-double-right"></i>
                </div>
            </li>`
        $('#lista-paginacion').html(elem);
        $('#lista-paginacion').parent().removeClass('d-none');
    }

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
<style>
    .file-view{
        cursor: pointer;
    }
    .file-view:hover{
        color: var(--verisAi) !important;
    }
</style>
@endpush