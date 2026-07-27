<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        
    <title>@yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/favicon.svg">
    <link rel="icon" type="image/png" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/favicon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/css/pages/page-auth.css" />
    <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/demo.css" />
    <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/theme-veris-app.css" />
    
    <!-- Vendors CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" /> --}}
    <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" /> --}}
    
    <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    @stack('css')

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/css/pages/cards-advance.css" />    
    <!-- Helpers -->
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    {{-- <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script> --}}

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/config.js"></script>
    <script>
        const app_ori = "APPWEB";
        const api_url = "{{ \App\Models\Veris::BASE_URL }}";
        const api_war = "{{ \App\Models\Veris::BASE_WAR }}";
        const api_war_general = "{{ \App\Models\Veris::BASE_WAR_GENERAL }}";
        @if (Session::has('user_external'))
        const _application = "{{ \App\Models\Veris::APPLICATION }}";;
        @else
        const _application = "{{ \App\Models\Veris::APPLICATION_FARMACIA }}";;
        @endif
        const _idOrganizacion = "{{ \App\Models\Veris::IDORGANIZACION }}";

        let _token = ""{{-- Session::get('userData')->tokenPush --}}
        let tipoFlujo = "";
        const url_site = "{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}";
        window.config = {
            subdomain: @json(config('app.subdomain')),
            canalOrigen: (@json(config('app.subdomain')) == "veris") ? "MVE_CMV" : "VER_PMF",
            {{-- canalOrigen: (@json(config('app.subdomain')) == "veris") ? "APP_CMV" : "VER_PMF", --}}
        };
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/block-ui@2.70.1/jquery.blockUI.min.js"></script> 

</head>

<body>
    <!-- Layout wrapper -->
    
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Menu -->
            {{-- @include('template.sidebar2') --}}
            <!-- / Menu -->

            <!-- Navbar -->
            @include('template.navbar2')
            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('template.footer2')
                    <!-- / Footer -->

                    <div class="content-backdrop fade d-none"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target d-none"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Modal 3DS Nuvei -->
    <div class="modal fade" id="modalIframe3DS" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalIframe3DSLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body p-3" id="box-iframe-3ds">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal eliminar cita -->
    <div class="modal fade" id="modalEliminarCita" tabindex="-1" aria-labelledby="modalEliminarCitaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-0">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Eliminar cita</h1>
                    <p class="fs--1 fw-normal text-veris" id="mensajeError">¿Estás seguro(a) de eliminar esta cita?</p>
                    <input type="hidden" id="idCitaEliminar">
                </div>
                <div class="modal-footer pt-0 pb-3 px-3 d-flex justify-content-around align-items-center">
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center" data-bs-dismiss="modal">Cancelar</div>
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center btn-confirmar-eliminar-cita">Eliminar</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal preparación previa -->
    <div class="modal fade" id="modalPreparacionPrevia" tabindex="-1" aria-labelledby="modalPreparacionPreviaCitaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-0">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Preparación previa</h1>
                    <div class="items-preparacion"></div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3 d-flex justify-content-end align-items-end">
                    <div class="text-veris fs--1 fw-medium cursor-pointer text-center" data-bs-dismiss="modal">Aceptar</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalError400" tabindex="-1" aria-labelledby="modalError400Label" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris" id="mensaje_400"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <a href="/" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3">Aceptar</a>
                    {{-- <button data-bs-dismiss="modal" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3">Aceptar</button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3ds -->
    <div class="modal fade" id="modalError3DS" tabindex="-1" aria-labelledby="modalError3DSLabel" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris" id="mensaje_3ds"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button data-bs-dismiss="modal" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalErrorSamePage" tabindex="-1" aria-labelledby="modalErrorSamePageLabel" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris" id="mensaje_400_same_page"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button data-bs-dismiss="modal" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Permite Cambio -->
    <div class="modal fade" id="modalPermiteCambiar" tabindex="-1" aria-labelledby="modalPermiteCambiarLabel" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris" id="mensajeNoPermiteCambiar"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambio Modalidad Error -->
    <div class="modal fade" id="modalPermiteCambiarModalidad" tabindex="-1" aria-labelledby="modalPermiteCambiarModalidadLabel" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Información</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris" id="mensajeNoPermiteCambiarModalidad"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal más opciones Citas-->
    <div class="modal modal-top fade" id="masOpcionesModalCitas" tabindex="-1" aria-labelledby="masOpcionesModalCitasLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-body pt-3 px-3 pb-3">
                    <h5 class="text-center fs--20 line-height-24 mb--32">{{ __('Más opciones') }}</h5>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="col-6 col-lg-6">
                            <div class="card card-border">
                                <div class="cursor-pointer data-popup-opciones-cita btn-CambiarFechaCita" id="modificar-cita-normal" data-bs-dismiss="modal">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-6 col-md-6">
                                            <div class="card-body p-0 ps-2">
                                                <h6 class="fw-medium fs--2 mb-0">{{ __('Cambiar') }} <br> {{ __('fecha de la') }}<br> {{ __('cita') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-auto text-end cita-presencial">
                                            <img src="{{ asset('assets/img/card/svg/cambiar_fecha_cita.svg') }}" class="img-fluid" alt="{{ __('Cambiar fecha de la cita') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-6">
                            <div class="card card-border">
                                <div class="cursor-pointer data-popup-opciones-cita btn-cambio-modalidad" id="cambiar-modalidad" data-bs-dismiss="modal">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-6 col-md-6">
                                            <div class="card-body p-0 ps-2">
                                                <h6 class="fw-medium fs--2 mb-0">{{ __('Modificar a') }}<br> {{ __('cita virtual') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-auto text-end">
                                            <img src="{{ asset('assets/img/card/svg/cambiar_modalidad_cita.svg') }}" class="img-fluid" alt="{{ __('Detalle Sesión') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal más opciones Odontología-->
    <div class="modal modal-top fade" id="masOpcionesModal" tabindex="-1" aria-labelledby="masOpcionesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-body pt-3 px-3 pb-3">
                    <h5 class="text-center fs--20 line-height-24 mb--32">{{ __('Más opciones') }}</h5>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="col-6 col-lg-6">
                            <div class="card card-border">
                                <a class="cursor-pointer data-popup-opciones btn-CambiarFechaCita" id="modificar-cita">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-6 col-md-6">
                                            <div class="card-body p-0 ps-2">
                                                <h6 class="fw-medium fs--2 mb-0">{{ __('Cambiar') }} <br> {{ __('fecha de la') }}<br> {{ __('cita') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-auto text-end cita-presencial">
                                            <img src="{{ asset('assets/img/card/svg/cambiar_fecha_cita.svg') }}" class="img-fluid" alt="{{ __('Cambiar fecha de la cita') }}">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-6">
                            <div class="card card-border">
                                <a class="cursor-pointer data-popup-opciones btn-sesion" id="detalle-sesion">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-6 col-md-6">
                                            <div class="card-body p-0 ps-2">
                                                <h6 class="fw-medium fs--2 mb-0">{{ __('Ver detalle') }}<br> {{ __('de la sesión') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-auto text-end">
                                            <img src="{{ asset('assets/img/card/svg/ver_detalle_sesion.svg') }}" class="img-fluid" alt="{{ __('Detalle Sesión') }}">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/js/bootstrap.js"></script>

    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/block-ui/block-ui.js"></script>

    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/datatables/jquery.dataTables.js"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/datatables-responsive/datatables.responsive.js"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js"></script>
    
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>

    <!-- Main JS -->
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js?v=1.1.1"></script>

    <script>
        // Inicializa Swiper.js
        var swiperProximasCitas,swiperUrgenciasAmbulatorias;
        function chartProgres(elemento){
            // console.log('elemento',elemento);

            var swiperTratamiento = new Swiper('.swiper-tratamientos', {
                // slidesPerView: 1,
                spaceBetween: 8,
                navigation: {
                    nextEl: '.btn-next',
                    prevEl: '.btn-prev',
                },
                autoplay: false,
                // watchOverflow: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                        // spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 2,
                        // spaceBetween: 8,
                    },
                    1024: {
                        slidesPerView: 2.7,
                        // spaceBetween: 8,
                    },
                },
            });

            swiperProximasCitas = new Swiper('.swiper-proximas-citas', {
                // slidesPerView: 1,
                spaceBetween: 8,
                navigation: {
                    nextEl: '.btn-next',
                    prevEl: '.btn-prev',
                },
                autoplay: false,
                // watchOverflow: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                        // spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 2,
                        // spaceBetween: 8,
                    },
                    1024: {
                        slidesPerView: 3,
                        // spaceBetween: 8,
                    },
                }/*,on: {
                    init: function() {
                        updateNavigation();
                    },
                    resize: function() {
                        updateNavigation();
                    },
                }*/

            });

            swiperUrgenciasAmbulatorias = new Swiper('.swiper-urgencias-ambulatorias', {
                // slidesPerView: 1,
                spaceBetween: 8,
                navigation: {
                    nextEl: '.btn-next',
                    prevEl: '.btn-prev',
                },
                autoplay: false,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                        // spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 2,
                        // spaceBetween: 8,
                    },
                    1024: {
                        slidesPerView: 3,
                        // spaceBetween: 8,
                    },
                },
            });

            
            
            
            /* // Inicializa apexchart
            let chartElements = document.querySelectorAll(elemento);
            // Mapea valores de atributos personalizados a colores
            let colorMapping = {
                'success': '#00c853',
                'primary': '#0071CE',
                // Agrega más mapeos aquí según tus necesidades
            };

            // Itera sobre cada elemento con la clase 'chart-progress'
            chartElements.forEach(function(chartElement) {
                // Obtiene los valores de los atributos de datos para el elemento actual
                let porcentaje = parseInt(chartElement.getAttribute('data-porcentaje'));
                let color = chartElement.getAttribute('data-color');

                // Obtén el color correspondiente del mapeo o usa el valor directamente si no está en el mapeo
                let colorSeleccionado = colorMapping[color] || color;

                // Configura los datos para ApexCharts para el elemento actual
                let options = {
                    chart: {
                        height: 110,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: '40%'
                            },
                            dataLabels: {
                                showOn: 'always',
                                name: {
                                    offsetY: -4,
                                    show: true,
                                    color: colorSeleccionado,
                                    fontSize: '10px'
                                },
                                value: {
                                    offsetY: -4,
                                    color: colorSeleccionado,
                                    fontSize: '14px',
                                    formatter: function(val) {
                                        return porcentaje + '%';
                                    }
                                }
                            }
                        }
                    },
                    series: [porcentaje],
                    labels: [''],
                    stroke: {
                        lineCap: 'round'
                    },
                    colors: [colorSeleccionado],
                };

                // Crea una nueva instancia de ApexCharts para el elemento actual
                let chart = new ApexCharts(chartElement, options);
                chart.render();
            }); */
        }
    </script>

    <!-- Funciones de ayuda -->
    <script>

        document.addEventListener("DOMContentLoaded", async function () {
            if(typeof dataCita !== "undefined" && dataCita.hasOwnProperty('tipoFlujo')){
                console.log(dataCita.tipoFlujo)
                tipoFlujo = dataCita.tipoFlujo;
            }
        })
        // capializar la primera letra de cada palabra
        function updateNavigation() {
            var totalSlides = swiperProximasCitas.slides.length - 2 * swiperProximasCitas.params.slidesPerView; // Eliminar duplicados en el bucle infinito
            if (totalSlides <= swiperProximasCitas.params.slidesPerView) {
                $('.swiper-button-prev').hide();
                $('.swiper-button-next').hide();
            } else {
                $('.swiper-button-prev').show();
                $('.swiper-button-next').show();
            }
        }

        // funcion quitar comillas a la url
        function quitarComillas(url){
            if (url == null) return "";
            let urlSinComillas = url.replace(/['"]+/g, '');
            return urlSinComillas;
        }

        //determinar valores null
        function determinarValorNull(valor){
            if (valor == null) return "";
            return valor;
        }

        function determinarValoresNull(valor){
            if (valor == null) return 0;
            return valor;
        }

        function logoutSystem(message){
            showMessage('warning', message);
            setTimeout(function(){
                window.location.href = "/logout";
            }, 2000);
        }

        function inicializarDatePickers() {
            @if (Session::has('user_external'))
            // Calcular el rango por defecto (Desde el 1 del mes actual hasta hoy)
            const hoy = new Date();
            const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);

            // Inicializar Flatpickr guardándolo en la variable global
            miPicker = flatpickr("#fecha", {
                mode: "range",
                maxDate: hoy, // Bloquea fechas futuras
                defaultDate: [primerDiaMes, hoy], // Rango inicial establecido
                dateFormat: "M j, Y", // Formato visual en pantalla: ej "jul. 1, 2026"
                showMonths: 1,            // Muestra 1 mes a la vez
                monthSelectorType: "dropdown", // Transforma el mes y año en un <select> estándar
                // Configuración de idioma en español con formato personalizado
                locale: {
                    firstDayOfWeek: 1,
                    rangeSeparator: " - ", // Reemplaza el "to" por el guion largo
                    weekdays: {
                        shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                        longhand: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
                    },
                    months: {
                        shorthand: ["ene.", "feb.", "mar.", "abr.", "may.", "jun.", "jul.", "ago.", "sep.", "oct.", "nov.", "dic."],
                        longhand: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    // Opcional: Aquí puedes reaccionar cada vez que el usuario cambia el rango
                    if (selectedDates.length === 2) {
                        console.log("Cambio detectado en pantalla: ", dateStr);
                    }
                }
            });

            @else
            // Calcular el rango por defecto (Desde el 1 del mes actual hasta hoy)
            const hoy = new Date();
            const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);

            // Inicializar Flatpickr guardándolo en la variable global
            miPicker = flatpickr("#fecha", {
                mode: "range",
                maxDate: hoy, // Bloquea fechas futuras al inicio
                defaultDate: [primerDiaMes, hoy], // Rango inicial establecido
                dateFormat: "M j, Y", // Formato visual en pantalla
                showMonths: 1,            // Muestra 1 mes a la vez
                monthSelectorType: "dropdown", 
                locale: {
                    firstDayOfWeek: 1,
                    rangeSeparator: " - ", 
                    weekdays: {
                        shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                        longhand: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
                    },
                    months: {
                        shorthand: ["ene.", "feb.", "mar.", "abr.", "may.", "jun.", "jul.", "ago.", "sep.", "oct.", "nov.", "dic."],
                        longhand: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    // AJUSTE PARA RANGO MÁXIMO DE 31 DÍAS:
                    if (selectedDates.length === 1) {
                        const fechaInicio = selectedDates[0];
                        
                        // Calculamos el límite mínimo y máximo alrededor de la fecha seleccionada
                        const minPermitido = new Date(fechaInicio);
                        minPermitido.setDate(fechaInicio.getDate() - 30); // 30 días hacia atrás

                        const maxCalculado = new Date(fechaInicio);
                        maxCalculado.setDate(fechaInicio.getDate() + 30); // 30 días hacia adelante (31 días en total contando el día de inicio)

                        // No nos podemos pasar del día de hoy en el futuro
                        const maxPermitido = maxCalculado > hoy ? hoy : maxCalculado;

                        // Aplicamos los límites temporales
                        instance.set("minDate", minPermitido);
                        instance.set("maxDate", maxPermitido);
                    } else {
                        // Si ya seleccionó el rango completo (2 fechas) o lo limpió, 
                        // restablecemos el comportamiento original
                        instance.set("minDate", null);
                        instance.set("maxDate", hoy);
                    }

                    if (selectedDates.length === 2) {
                        console.log("Cambio detectado en pantalla: ", dateStr);
                    }
                },
                // Restaurar los límites si el usuario cierra el selector sin completar la selección de 2 fechas
                onClose: function(selectedDates, dateStr, instance) {
                    instance.set("minDate", null);
                    instance.set("maxDate", hoy);
                }
            });
            @endif
            // Deshabilitar autocompletado
            $("#fecha").attr("autocomplete", "off");
        }

        // --- FUNCIÓN EXTERNA SOLICITADA ---
        // Devuelve un objeto con las fechas formateadas en dd/mm/yyyy
        function obtenerFechasFormateadas() {
            if (!miPicker || miPicker.selectedDates.length < 2) {
                console.warn("El rango de fechas no está completo.");
                return null;
            }

            const fechas = miPicker.selectedDates;
            
            // Forzamos el formato dd/mm/yyyy internamente mediante Flatpickr
            const fechaDesde = miPicker.formatDate(fechas[0], "d/m/Y");
            const fechaHasta = miPicker.formatDate(fechas[1], "d/m/Y");

            return {
                fechaDesde: fechaDesde, // "01/07/2026"
                fechaHasta: fechaHasta  // "12/07/2026"
            };
        }

        // Función auxiliar para que veas el resultado en la consola al hacer clic en el botón
        function probarObtenerFechas() {
            const rango = obtenerFechasFormateadas();
            if (rango) {
                console.log("-----------------------------------------");
                console.log("Fecha Desde (Formateada):", rango.fechaDesde);
                console.log("Fecha Hasta (Formateada):", rango.fechaHasta);
                console.log("-----------------------------------------");
                alert(`Desde: ${rango.fechaDesde}\nHasta: ${rango.fechaHasta}`);
            } else {
                alert("Por favor, selecciona un rango de 2 fechas en el calendario.");
            }
        }
    </script>
    <style>
        .numInputWrapper {
            margin-left: 5px;
        }

        /* 2. Forzar que el contenedor de las flechas sea visible y se posicione a la derecha */
        .flatpickr-current-month .numInputWrapper span {
            display: block !important;
            opacity: 1 !important;
            position: absolute !important;
            right: 0 !important;
            width: 16px !important;
            height: 50% !important;
            box-sizing: border-box !important;
            cursor: pointer !important;
            border: none !important;
        }

        /* 3. Re-dibujar los triángulos internos de las flechas (por si Bootstrap los borró) */
        .flatpickr-current-month .numInputWrapper span:after {
            content: "" !important;
            display: block !important;
            position: absolute !important;
            left: 4px !important;
            width: 0 !important;
            height: 0 !important;
            border-left: 4px solid transparent !important;
            border-right: 4px solid transparent !important;
        }

        .flatpickr-current-month .numInputWrapper span.arrowUp:after {
            top: 4px !important;
            border-bottom: 5px solid #555 !important; /* Triángulo hacia arriba */
        }

        .flatpickr-current-month .numInputWrapper span.arrowDown:after {
            top: 3px !important;
            border-top: 5px solid #555 !important; /* Triángulo hacia abajo */
        }

        /* Cambiar de color al pasar el mouse por encima de las flechas */
        .flatpickr-current-month .numInputWrapper span:hover {
            background: rgba(0, 0, 0, 0.05) !important;
        }

        span.flatpickr-day.inRange {
            font-weight: 700;
        }
    </style>    
    @stack('scripts')
</body>

</html>