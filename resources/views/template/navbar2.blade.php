@php
    $tokenPaquete = base64_encode(uniqid());
@endphp
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme-veris pe-3" id="layout-navbar">
    {{-- <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none p-2 px-3 bg-dark-blue-veris">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" style="margin-bottom: 0.10rem;">
            <i class="ti ti-menu-2 ti-sm text-white"></i>
        </a>
    </div> --}}

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Logo veris -->
        <a class="navbar-brand mx-auto" href="#">
            {{-- <img src="{{ asset('assets/img/veris/logo-veris.svg') }}" class="ml-lg-10" alt="veris" width="84"> --}}
            <img src="{{ asset('assets/img/'.config('app.subdomain').'/logo-'.config('app.subdomain').'.svg') }}" class="ml-lg-12" alt="veris" width="84">
        </a>
        <ul class="navbar-nav flex-row align-items-center">
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar-sm avatar-online">
                        <img src="{{ asset('assets/img/avatars/avatar.svg') }}" alt class="h-auto rounded-circle" />
                    </div>
                    <span class="fs--1 ms-2 d-none d-lg-block">{{-- Session::get('userData')->nombre --}}mwrosero</span>
                    <i class="fa-solid fa-angle-down d-none d-lg-block ms-2"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end rounded-3 mt-2 py-1">
                    <li>
                        <a class="dropdown-item fs--1 d-flex align-items-center mb-0" href="{{-- route('cuenta.miCuenta') --}}">
                            <i class="fa-solid fa-lock text-primary-veris me-2 ti-sm"></i>
                            <span class="align-middle">Cambiar clave</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item fs--1 d-flex align-items-center mb-0 cursor-pointer" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fa-solid fa-arrow-right-to-bracket text-primary-veris me-2 ti-sm"></i>
                            <span class="align-middle">Cerrar sesión</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3 text-center">
                <p class="text-danger fs-48 mb-0"><i class="fa-solid fa-triangle-exclamation me-2"></i></p>
                <h5 class="fs-24 line-height-28 my-2">Cerrar sesión</h5>
                <p class="fs--16 line-height-20 text-veris mb-0">¿Estás seguro que deseas cerrar sesión?.</p>
                <div class="d-flex">
                    <button type="button" class="btn btn-lg btn-outline-primary-veris fs--18 col me-1 mt-3 m-0 px-4 py-3" data-bs-dismiss="modal">No</button>
                    <a class="btn btn-lg btn-primary-veris fs--18 col ms-1 mt-3 m-0 px-4 py-3" id="logout">Si, cerrar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal PPD -->
<div class="modal fade" id="modalPPD" tabindex="-1" aria-labelledby="modalPPDLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3 text-center">
                <h5 class="fs-24 line-height-28 my-3"  id="tituloInformacionCita">{{ __('Información') }}</h5>
                <p class="fs--1 line-height-16 mb-0">Como en Veris cuidarte es tan fácil, hemos creado nuevas <a href="https://www.veris.com.ec/politicas/" id="politicasPPD" target="_blank">políticas de privacidad de datos</a></p>
                <div class="d-flex flex-column">
                    <button type="button" id="aceptarPDP" class="btn btn-lg btn-primary-veris fw-medium col fs--18 mt-3 m-0 px-4 py-3">Aceptar</button>
                    <button type="button" class="btn btn-lg shadow-none text-primary-veris fw-medium col fs--18 mt-3 m-0 px-4 py-3" id="modalRecuerdame">Recuérdame más tarde </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal PPD -->
<div class="modal fade" id="modalPPD2" tabindex="-1" aria-labelledby="modalPPD2Label" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3 text-start">
                {{-- <h5 class="fs--2 line-height-28 my-3"  id="tituloPPD2"></h5>
                <p class="fs--2 line-height-16 mb-0" id="subtituloPPD2"></p>
                <p class="fs--2 line-height-16 mb-0 btn-mostrar-ppd2">Mostrar todo</p> --}}
                <div class="resumen-consentimiento"></div>
                <p class="text-decoration-underline fs--2 line-height-16 my-3 text-Secundario-Midnight-blue-Tint-40 link-mostrar-todo-ppd2 cursor-pointer">Mostrar todo</p>
                <div class="d-flex flex-column">
                    <button type="button" id="aceptarPPD2" class="btn btn-lg btn-primary-veris fw-medium col fs--18 mt-3 m-0 px-4 py-3">Aceptar</button>
                    <button type="button" class="btn btn-lg shadow-none text-Secundario-Midnight-blue-Tint-40 fw-medium col fs--18 mt-3 m-0 px-4 py-3" id="configuracionPPD2">Configuración</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notificaciones -->
<div class="offcanvas offcanvas-end" style="margin-top: 62px;" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
    <div class="offcanvas-header flex-column align-items-start p-0">
        <div class="w-100 px-4 py-2 text-end" style="background: #F3F4F5;">
            <button type="button" class="btn btn-sm fs--1 text-primary-veris fw-normal line-height-16 shadow-none text-decoration-underline p-2" data-bs-dismiss="offcanvas" aria-label="Close">Cerrar</button>
        </div>
        <h5 class="offcanvas-title fs-20 line-height-24 w-100 px-4 py-3 bg-white" id="offcanvasEndLabel">Notificaciones</h5>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 py-0 px-0" style="background: #F3F4F5 !important;">
        <div class="d-flex flex-column border-300" id="notificaciones" style="min-height: 75vh;">
            <!-- Notificaciones dinamicas -->
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center py-5 d-none" id="noNotificaciones">
            <img src="{{ asset('assets/img/svg/bellNotificacion.svg') }}" alt="" width="50px" class="mb-3">
            <h5 class="fs-24 line-height-28 fw-medium mb-4">No tienes notificaciones</h5>
            <p class="fs--16 line-height-20 text-veris fw-normal mb-4 w-75 text-center"> En esta sección podrás revisar tus notificaciones</p>
            <img src="{{ asset('assets/img/svg/amico.svg') }}" alt="" class="img-fluid w-50">
        </div>
    </div>
    <div class="offcanvas-footer" style="background: #F3F4F5;">
        <div class="" id="paginationContainer">
            <!-- Paginación aquí -->
        </div>
    </div>
</div>

<script>
    
    $('#logout').click(function(){
        // localStorage.clear();
        for (let i = 0; i < localStorage.length; i++) {
            let key = localStorage.key(i);
            if (key.startsWith('cita-') || key.startsWith('persona-')) {
                localStorage.removeItem(key);
                i--; // Ajustar el índice después de eliminar un elemento
            }
        }

        window.location.href = "{{-- route('logout') --}}";
    });
</script>
<style>
    .fa-solid.fa-bell {
        position: relative;
        font-size: 24px; /* ajusta el tamaño según sea necesario */
    }

    /*#numeroNotificaciones {
        position: absolute;
        bottom: 0;
        right: 0;
        transform: translate(50%, 50%);
        font-size: 12px;
    }*/

    .verisNotificacion {
        font-family: Gotham Rounded;
        font-size: 14px;
        font-weight: 350;
        line-height: 16px;
        letter-spacing: 0em;
        text-align: left;
        color: #0071CE;
    }

    .icon-button__badge {
        position: absolute;
        top: 13px;
        right: -10px;
        width: 12px;
        height: 12px;
        background: #FF0000;
        color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        font-size: 40%;
        padding: 9px;
    }

    .layout-navbar {
        height: 3.74rem !important;
        {{-- height: 58px !important; --}}
    }

    .layout-navbar-fixed .layout-wrapper:not(.layout-horizontal) .layout-page:before {
        height: 58px !important;
    }

    @media screen and (min-width: 1200px) {
        .icon-button__badge{
            right: 0px;
        }
    }
</style>