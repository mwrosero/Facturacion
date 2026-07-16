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
        <link rel="stylesheet" href="../../../assets/vendor/fonts/fontawesome.css" />
        <link rel="stylesheet" href="../../../assets/vendor/fonts/tabler-icons.css" />
        <link rel="stylesheet" href="../../../assets/vendor/fonts/flag-icons.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

        <!-- Core CSS -->
        <link rel="stylesheet" href="../../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="../../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="../../../assets/vendor/css/pages/page-auth.css" />
        <link rel="stylesheet" href="../../../assets/css/demo.css" />
        <link rel="stylesheet" href="../../../assets/css/style.css" />
        {{-- <link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0.4')}}"> --}}
        @if(config('app.subdomain') == "parami")
        <link rel="stylesheet" href="{{ asset('assets/css/theme-parami-app.css?v=1.0.4')}}">
        @endif
        <!-- Vendors CSS -->
        
        <link rel="stylesheet" href="../../../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />

        <!-- Page CSS -->
        <script src="../../../assets/vendor/js/helpers.js"></script>
        <!-- Helpers -->

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        {{-- <script src="../../../assets/vendor/js/template-customizer.js"></script> --}}
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="../../../assets/js/config.js"></script>
        {{-- <script src="../../../assets/vendor/libs/jquery/jquery.js"></script> --}}
        <script>
            //localStorage.clear();
            for (let i = 0; i < localStorage.length; i++) {
                let key = localStorage.key(i);
                if (key.startsWith('cita-')) {
                    localStorage.removeItem(key);
                    i--; // Ajustar el índice después de eliminar un elemento
                }
            }
            const api_url = "{{ \App\Models\Veris::BASE_URL }}";
            const api_war = "{{ \App\Models\Veris::BASE_WAR }}";
            {{-- let _token = "{{ $accessToken }}"; --}}
            const url_site = "{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}";
            let tipoFlujo = "";
            window.config = {
                subdomain: @json(config('app.subdomain')),
                canalOrigen: (@json(config('app.subdomain')) == "veris") ? "MVE_CMV" : "VER_PMF",
                {{-- canalOrigen: (@json(config('app.subdomain')) == "veris") ? "APP_CMV" : "VER_PMF", --}}
            };
        </script>
        
        {{-- @include('template.analytics') --}}
    </head>

    <body class="bg-fondo">
        <!-- Content -->
        @yield('back-button')

        @if (Session::has('user_external'))
        <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
            <div class="layout-container">
                <!-- Navbar -->
                @include('template.navbar2')
                <!-- / Navbar -->

                <!-- Layout container -->
                <div class="layout-page">

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <div class="flex-grow-1 container-p-y pt-0" style="background-color: #e4e5e6;">
                            <div class="d-flex justify-content-between align-items-center bg-white">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">Actualizar Contraseña</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="container mt-3">
                                <div class="row">
                                    <div class="col-12 col-md-6 offset-md-3 col-xl-4 offset-xl-4">
                                        <div class="card shadow-none">
                                            <div class="card-body px-0 px-md-4 px-3">
                                                @yield('content')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Content -->
                        </div>

                        <!-- Footer -->
                        @include('template.footer2')
                        <!-- / Footer -->

                        <div class="content-backdrop fade d-none"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>
        </div>
        @else        
        <div class="container-xxl">
            <div class="authentication-wrapper authentication-basic">
                <div class="authentication-inner">
                    <div class="card shadow-none">
                        <div class="card-body px-0 px-md-4">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @component('components.modal', ['id' => 'modalAlert', 'title' => 'Error', 'message' => session('alert')])
            <button type="button" class="btn btn-primary">Aceptar</button>
        @endcomponent

        <!-- Modal -->
        <div class="modal fade" id="modalError400" tabindex="-1" aria-labelledby="modalError400Label" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
                <div class="modal-content">
                    <div class="modal-body text-center p-3">
                        <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                        <p class="fs--1 fw-normal mb-0 text-veris" id="mensaje_400"></p>
                    </div>
                    <div class="modal-footer pt-0 pb-3 px-3">
                        <button class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

      <!-- Core JS -->
      <!-- build:js assets/vendor/js/core.js -->

      <script src="../../../assets/vendor/libs/popper/popper.js"></script>
      <script src="../../../assets/vendor/js/bootstrap.js"></script>
      <script src="../../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
      <script src="../../../assets/vendor/libs/node-waves/node-waves.js"></script>
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/block-ui/block-ui.js"></script>

      <script src="../../../assets/vendor/libs/hammer/hammer.js"></script>
      <script src="../../../assets/vendor/libs/i18n/i18n.js"></script>
      <script src="../../../assets/vendor/libs/typeahead-js/typeahead.js"></script>

      <script src="../../../assets/vendor/js/menu.js"></script>
      <!-- endbuild -->

      <!-- Vendors JS -->
      <script src="../../../assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
      <script src="../../../assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>
      <!--<script src="../../../assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>-->

      <!-- Main JS -->
      {{-- <script src="../../../assets/js/main.js"></script> --}}

      <!-- Page JS -->
      {{-- <script src="../../../assets/js/pages-auth.js"></script> --}}
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js?v=1.0.6"></script>

        @if (session()->has('alert'))
        <script>
            $(document).ready(function() {
                $('#modalAlert').modal('show');
            });
        </script>
        @endif
    <style>
        .bg-navbar-theme-veris {
            background-color: #296BEF !important;
            color: #fff !important;
        }
    </style>    
</body>
</html>