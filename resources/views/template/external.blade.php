<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../../../../assets/"
    data-template="vertical-menu-template-starter" >
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        
        <title>@yield('title')</title>
        <meta name="description" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/favicon.svg">
        <link rel="icon" type="image/png" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/favicon.png">

        <!-- <link rel="manifest" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/manifest.json"> -->
        <meta name="msapplication-TileColor" content="#0071CE">
        <meta name="theme-color" content="#0071CE">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/fonts/fontawesome.css" />
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/fonts/tabler-icons.css" />
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/fonts/flag-icons.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/css/pages/page-auth.css" />
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/demo.css" />
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/style.css" />

        <!-- Vendors CSS -->
        
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />

        <!-- Page CSS -->
        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/js/helpers.js"></script>
        <!-- Helpers -->

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        {{-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/js/template-customizer.js"></script> --}}
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/config.js"></script>
        {{-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/jquery/jquery.js"></script> --}}
        <script>
            const api_url = "{{ \App\Models\Veris::BASE_URL }}";
            const api_war = "{{ \App\Models\Veris::BASE_WAR }}";
            const api_war_ai = "{{ \App\Models\Veris::BASE_WAR_AI }}";
            const _application = "{{ \App\Models\Veris::APPLICATION }}";
            let _idOrganizacion = "{{ \App\Models\Veris::IDORGANIZACION }}";
            let _token = "{{ $accessToken }}";
            // "@if (\App\Models\Veris::CONTIENE_DESARROLLO)  {{ \App\Models\Veris::IDORGANIZACIONRESULTADOSLAB }} @else {{ \App\Models\Veris::IDORGANIZACION }} @endif";
            // const _idOrganizacionResultadosLaboratorio = "";
            let tipoFlujo = "";
            const url_site = "{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}";
            window.config = {
                subdomain: @json(config('app.subdomain')),
                canalOrigen: (@json(config('app.subdomain')) == "veris") ? "VER_CMV" : "VER_PMF"
            };
        </script>
        
        @include('template.analytics-external')
    </head>

    <body>
        @include('template.analytics-external-no-script')
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        {{-- <div class="layout-wrapper layout-content-navbar"> --}}
            <div class="layout-container">
                <!-- Menu -->
                {{-- @include('template.sidebar2') --}}
                <!-- / Menu -->

                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->
                    {{-- @include('template.navbar2') --}}
                    <!-- / Navbar -->

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->
                        <div class="container-fluid flex-grow-1 m-0 p-0">
                            @yield('content')
                        </div>
                        <!-- / Content -->

                        <!-- Footer -->
                        {{-- @include('template.footer2') --}}
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

        <!-- Modal -->
        <div class="modal fade" id="modalError400" tabindex="-1" aria-labelledby="modalError400Label" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
                <div class="modal-content">
                    <div class="modal-body text-center p-3">
                        <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                        <p class="fs--1 fw-normal mb-0 text-veris" id="mensaje_400"></p>
                    </div>
                    <div class="modal-footer pt-0 pb-3 px-3">
                        <div data-bs-dismiss="modal" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3">Aceptar</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Antifraude -->
        <div class="modal fade" id="modalAntifraude" tabindex="-1" aria-labelledby="modalAntifraudeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
                <div class="modal-content">
                    <div class="modal-header pt-3 pb-0 px-3">
                        <h5 class="modal-title mx-auto title-section fw-bold fs--18">Validación del sistema antifraude</h5>
                    </div>
                    <div class="modal-body text-center p-3">
                        <span class="fs--14 line-height-16">Ingresa el número de identificación del tarjetahabiente.</span>
                        <div class="w-100 mt-4 text-start">
                            <label for="tipoIdentificacionTH" class="form-label fw-medium fs--1">Tipo de identificación *</label>
                            <select class="form-select fs--1 p-3" name="tipoIdentificacionTH" id="tipoIdentificacionTH" required>
                                <option value="2">Cédula</option>
                                <option value="1">RUC</option>
                                <option value="3">Pasaporte</option>
                            </select>
                        </div>
                        <div class="w-100 mt-4 text-start">
                            <label for="numeroIdentificacionTH" class="form-label fw-medium fs--1">Número de identificación *</label>
                            <input type="text" class="form-control fs--1 p-3" name="numeroIdentificacionTH" id="numeroIdentificacionTH" placeholder="0999999999" required />
                            <div class="invalid-feedback-th text-danger d-none">
                                Ingrese un número de identificación válido.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0 pb-3 px-3">
                        <button type="button" class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3 m-0 btn-validar-antifraude disabled">Enviar</button>
                    </div>
                </div>
            </div>
        </div>

      <!-- Core JS -->
      <!-- build:js assets/vendor/js/core.js -->

      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/popper/popper.js"></script>
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/js/bootstrap.js"></script>
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/node-waves/node-waves.js"></script>
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/block-ui/block-ui.js"></script>

      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/hammer/hammer.js"></script>
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/i18n/i18n.js"></script>
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/typeahead-js/typeahead.js"></script>

      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/js/menu.js"></script>
      <!-- endbuild -->

      <!-- Vendors JS -->
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>
      <!--<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>-->

      <!-- Main JS -->
      {{-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/main.js"></script> --}}

      <!-- Page JS -->
      {{-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/pages-auth.js"></script> --}}
      {{-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script> --}}

        @if (session()->has('alert'))
        <script>
            $(document).ready(function() {
                $('#modalAlert').modal('show');
            });
        </script>
        @endif
</body>
</html>