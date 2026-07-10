<!--off canva filtro-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="filtroTratamientos" aria-labelledby="filtroTratamientosLabel">
    <div class="offcanvas-header flex-column align-items-start p-0">
        <div class="w-100 px-4 py-2 d-lg-none d-block" style="background: #F3F4F5;">
            <button type="button" class="btn p-0 d-flex align-items-center" data-bs-dismiss="offcanvas" aria-label="Close"><img src="{{asset('assets/img/svg/arrow-left-filtro-body.svg')}}" class="me-1" alt="atras"><b class="fw-medium fs-- text-veris">Atrás</b></button>
        </div>
        <h5 class="offcanvas-title fs--20 line-height-24 w-100 px-4 py-3" id="filtroTratamientosLabel">Filtros</h5>
    </div>
    <div class="offcanvas-body px-3 pt--2" style="background: rgba(249, 250, 251, 1);">
        <div>
            <h6 class="fs--16 line-height-20 fw-light" style="color: #3D4E66 !important;">Selecciona el paciente</h6>
            <div class="list-group gap-3 mb-3 listaPacientesFiltro">
                <!-- Puedes agregar lista de pacientes dinámicamente aquí desde JavaScript -->
            </div>
            <div class="col-md-12 mb-3 box-fechas-filtro">
                <label for="fechaDesde" class="fw-light fs--16 line-height-20 mb-3" style="color: #3D4E66 !important;">{{ __('Elige el rango de fechas') }}</label>
                <input type="text" class="form-control fs--1 p-3" placeholder="Desde la fecha" name="fechaDesde" id="fechaDesde" required />
            </div>
            <div class="col-md-12 mb-5 box-fechas-filtro">
                <input type="text" class="form-control fs--1 p-3" placeholder="Hasta la fecha" name="fechaHasta" id="fechaHasta" required />
            </div>
            <div class="col-md-12 mb-3">
                <button class="btn btn-primary-veris w-100 fs--18 line-height-24 mb-2 mx-0 px-4 py-3" type="button" id="aplicarFiltros" data-context="contextoAplicarFiltros">Aplicar filtros</button>
                <button class="btn text-primary w-100 fs--18 line-height-24 mb-2 mx-0 px-4 py-3" type="button" id="btnLimpiarFiltros" data-context="contextoLimpiarFiltros"><img src="{{asset('assets/img/svg/delete-blue.svg')}}" class="me-2" alt="linmpiar filtro">Limpiar filtros</button>
            </div>
        </div>
    </div>
</div>