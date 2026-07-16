@extends('template.login')
@section('title')
    Veris - Recuperar Clave
@endsection
@section('back-button')
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="{{ route('login') }}" class="text-decoration-none">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 16px;">
            <img src="../../assets/img/svg/atras.svg" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium" style="font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
@endsection
@section('content')
<!-- Logo -->
<div class="text-center mb-5">
    <img class="logo-login" src="../../assets/img/veris/logo-veris-2025.svg">
</div>
<!-- /Logo -->
<form id="formAuthentication" class="mb-3" action="/recuperar-clave" method="POST">
    @csrf
    <div class="my-3">
        <div class="alert alert-primary fs--3">
            <p class="mb-2">Estimado Cliente, ingresa tu número de identificación.</p>
            <p class="mb-0">Recibirás una clave temporal en tu correo electrónico para poder acceder.</p>
        </div>
    </div>
    @if (session()->has('mensaje'))
        <div class="alert alert-warning fs--3">
            {{ session('mensaje') }} 
        </div>
    @endif
    @if($errors->has('csrf_token'))
        <div class="alert alert-warning">
            {{ $errors->first('csrf_token') }}
        </div>
    @endif
    <div class="mb-3">
        <label for="numeroIdentificacion" class="form-label fw-medium">Usuario *</label>
        <input type="text"
            class="form-control fs--1 p-3"
            id="numeroIdentificacion"
            name="numeroIdentificacion"
            oninput="limitarCaracteres(this, 13)"
            {{-- onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" --}}
            placeholder="Ingresa tu número de identificación"
            @if (session()->has('numeroIdentificacion'))
            value="{{ session('numeroIdentificacion') }}"
            @endif
            autofocus />
    </div>
    <div class="mt-4 mb-3">
        <button class="btn d-grid w-100 btn-primary-veris fs--18 line-height-24 fw-medium px-4 py-3 rounded" id="btnRecuperar" type="submit">{{ __('Enviar')}}</button>
    </div>
</form>
<script>

    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("formAuthentication");
        var submitButton = document.getElementById("btnRecuperar");

        form.addEventListener("submit", function(event) {
            // Realiza tu validación aquí
            if (!validateForm()) {
                event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
            }
        });

        function validateForm(){
            let errors = false;
            let msg = `<ul class="ms-0 text-start text-veris">`;
            if(getInput('numeroIdentificacion') == ""){
                errors = true;
                msg += `<li class="ms-0">Campo usuario es requerido</li>`;
            }
            msg += `</ul>`;
            if(errors){
                $('#modalAlertTitle').html('Campos requeridos');
                $('#modalAlertMessage').html(msg);
                $('#modalAlert').modal('show');
            }
            return !errors;
        }
    });
</script>
@endsection