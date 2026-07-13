<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme-veris">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link text-white">
            <span class="app-brand-text demo menu-text fw-bold">Menú</span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Menu -->
        <li class="menu-item {{ Route::is('home') || Route::is('home.*')  ? 'active' : '' }}">
            <a href="{{route('home')}}" class="menu-link fs--1 text-white">
                <div class="svg-container svg-inicio me-3"></div>
                <div data-i18n="Inicio">Inicio</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('cuenta') || Route::is('cuenta.*')  ? 'active' : '' }}">
            <a href="{{route('cuenta.miCuenta')}}" class="menu-link fs--1 text-white">
                <div class="svg-container svg-cuenta me-3"></div>
                <div data-i18n="Cuenta">Cuenta</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('citas') || Route::is('citas.*')  ? 'active' : '' }}">
            <a href="{{route('citas')}}" class="menu-link fs--1 text-white">
                <div class="svg-container svg-citas me-3"></div>
                <div data-i18n="Citas">Citas</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('tratamientos') || Route::is('tratamientos.*')  ? 'active' : '' }}">
            <a href="{{route('tratamientos')}}" class="menu-link fs--1 text-white">
                <div class="svg-container svg-tratamientos me-3"></div>
                <div data-i18n="Tratamientos">Tratamientos</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('resultados') || Route::is('resultados.*')  ? 'active' : '' }}">
            <a href="{{route('resultados')}}" class="menu-link fs--1 text-white">
                <div class="svg-container svg-resultados me-3"></div>
                <div data-i18n="Resultados">Resultados</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('promociones.promociones') || Route::is('promociones.*')  ? 'active' : '' }}">
            <a href="{{route('promociones.promociones')}}" class="menu-link fs--1 text-white">
                <div class="svg-container svg-promociones me-3"></div>
                <div data-i18n="Paquetes Preventivos">Paquetes Preventivos</div>
            </a>
        </li>
        @if(config('app.subdomain') == "veris")
        <li class="menu-item {{ Route::is('domicilio') || Route::is('domicilio.*')  ? 'active' : '' }}">
            <a href="{{route('domicilio')}}" class="menu-link fs--1 text-white">
                <div class="svg-container svg-domicilio me-3"></div>
                <div data-i18n="Domicilio">Domicilio</div>
            </a>
        </li>
        @endif
        {{-- <li class="menu-item {{ Route::is('familia') || Route::is('familia.*')  ? 'active' : '' }}">
            <a href="{{route('familia.lista')}}" class="menu-link fs--1 text-white">
                <div class="svg-container svg-familia me-3"></div>
                <div data-i18n="Familia y amigos">Familia y amigos</div>
            </a>
        </li> --}}
        <li class="menu-item {{ Route::is('doctoresFavoritos') || Route::is('doctoresFavoritos.*')  ? 'active' : '' }}">
            <a href="{{route('doctoresFavoritos')}}" class="menu-link fs--1 text-white">
                <div class="svg-container svg-doctoresFavoritos me-3"></div>
                <div data-i18n="Doctores favoritos">Doctores favoritos</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('historiaClinica') || Route::is('historiaClinica.*')  ? 'active' : '' }}">
            <a href="{{route('historiaClinica')}}" class="menu-link fs--1 text-white">
                <div class="svg-container svg-historiaClinica me-3"></div> 
                <div class="text-one-line" data-i18n="Solicitar historia clínica">Solicitar historia clínica</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('experiencia') || Route::is('experiencia.*')  ? 'active' : '' }}">
            <a href="{{route('experiencia')}}" class="menu-link fs--1 text-white">
                <div class="svg-container svg-experiencia me-3"></div>
                <div class="text-one-line" data-i18n="Cuéntanos tu experiencia">Cuéntanos tu experiencia</div>
            </a>
        </li>
    </ul>
</aside>