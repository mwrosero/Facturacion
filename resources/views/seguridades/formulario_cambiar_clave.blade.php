@extends('template.login')
@section('title')
    Veris - Actualizar Contraseña
@endsection
@section('content')
<!-- Content Actualizar Clave -->
@if (!Session::has('user_external'))
<p class="fs-4 mb-1 pt-2 text-center bg-colortext fw-medium">Actualizar Contraseña</p>
<p class="fs-10 mb-3 text-center bg-colortext">Por motivos de seguridad debes actualizar tu contraseña para activar tu cuenta.</p>
@endif
{{-- <form id="formAuthentication" class="mb-3" method="post" action="/actualizar-clave" onsubmit="return validarClave()"> --}}
<form id="formAuthentication" class="mb-3" method="post" action="/actualizar-clave">
    @csrf
    @if (!Session::has('user_external'))
    <input type="hidden" name="usuario" value="{{ $codigoUsuario }}">
    <input type="hidden" name="numeroIdentificacion" value="{{ $numeroIdentificacion }}">
    <input type="hidden" name="claveActual" value="{{ $claveActual }}">
    @endif
    @if (session()->has('mensaje'))
        <div class="alert alert-warning">
        {{ session('mensaje') }}
        </div>
    @endif
    <div class="mb-2">
        <label for="nuevaClave" class="form-label bg-colortext fw-medium fs--1 mt-2">Nueva contraseña</label>
        <div class="input-group fs--1 input-group-merge">
            <input type="password"
                class="form-control fs--1 p-3"
                id="nuevaClave"
                name="nuevaClave"
                autofocus
                required />
            <span id="togglePassword" class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
        </div>
        <div class="checklist-box p-2 my-2 rounded">
            <p class="fw-medium mb-2 bg-colortext">Su password debe contener al menos:</p>
            <ul class="checklist px-2">
                {{-- <li id="firstLetter">Debe iniciar con una letra mayúscula</li> --}}
                <li id="uppercase">Incluir Mayúscula</li>
                <li id="lowercase">Incluir Minúscula</li>
                <li id="numbers">Incluir Números</li>
                <li id="length">Tamaño exacto 10 caracteres</li>
                <li id="special">Caracteres Especiales <b class="ms-1 text-dark">#$%*_-+=!</b></li>
            </ul>
        </div>
    </div>
    <div class="mb-3">
        <label for="confirmarClave" class="form-label bg-colortext fw-medium fs--1 mt-2">Confirmar nueva contraseña</label>
        <div class="input-group fs--1 input-group-merge">
            <input type="password"
                class="form-control fs--1 p-3"
                id="confirmarClave"
                name="confirmarClave"
                autofocus
                required />
            <span id="togglePassword2" class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
        </div>
    </div>
    <div class="mb-3">
        <button class="btn fs--18 fw-medium line-height-24 px-4 py-3 d-grid w-100 bg-veris" type="submit" id="recuperarContrasena">Actualizar Contraseña</button>
    </div>
</form>
<!-- /Content Actualizar Clave -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('nuevaClave');

        passwordInput.addEventListener('input', () => {
            let value = passwordInput.value;
            const allowedCharsStr = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#$%*_-+=!";

            // 1. RESTRICCIÓN: No permitir escribir más de 10 caracteres
            if (value.length > 10) {
                passwordInput.value = value.substring(0, 10);
                value = passwordInput.value; // Actualizamos la referencia de 'value'
            }

            // 2. FILTRADO de caracteres prohibidos (valida la tecla o carácter que se acaba de ingresar)
            if (value.length > 0) {
                const lastChar = value.slice(-1);
                if (!allowedCharsStr.includes(lastChar)) {
                    passwordInput.value = value.slice(0, -1);
                    value = passwordInput.value; // Actualizamos la referencia tras borrar
                    showMessage('warning', 'Atención', `Caracter "${lastChar}" no permitido.`);
                    return; 
                }
            }

            // 3. Validación visual en tiempo real
            for (const key in requirements) {
                const element = document.getElementById(key);
                if (element) {
                    // Se marcará en verde solo si cumple la condición de su Regex
                    element.classList.toggle('valid', value.length > 0 && requirements[key].test(value));
                }
            }

        });

        const form = document.getElementById('formAuthentication');

        form.addEventListener('submit', function(event) {
            var nuevaClave = document.getElementById("nuevaClave").value;
            var confirmarClave = document.getElementById("confirmarClave").value;
            
            let hayError = false;
            let mensajeError = "";

            if (nuevaClave.length !== 10) {
                hayError = true;
                mensajeError = "La nueva contraseña debe tener exactamente 10 caracteres.";
            } else if (nuevaClave !== confirmarClave) {
                hayError = true;
                mensajeError = "Las contraseñas no coinciden.";
            }else {
                const isComplex = Object.values(requirements).every(regex => regex.test(nuevaClave));
        
                if (!isComplex) {
                    hayError = true;
                    mensajeError = "La contraseña debe incluir: Mayúscula, Minúscula, Número y Carácter especial.";
                }
                {{-- 
                if (!re.test(nuevaClave)) {
                    hayError = true;
                    mensajeError = "La contraseña debe incluir: Mayúscula, Minúscula, Número y Carácter especial.";
                } --}}
            }

            // 5. Si hay error, DETENEMOS el envío
            if (hayError) {
                event.preventDefault(); // ESTO es lo que evita que se envíe el form
                
                // Verificamos si showMessage existe para evitar crash
                if (typeof showMessage === "function") {
                    showMessage('warning', 'Atención', mensajeError);
                } else {
                    // Fallback por si la librería visual falla
                    alert(mensajeError);
                }
                
                return false;
            }

            // Si llega aquí, el formulario se envía normalmente
        });
    });

    const passwordInput = document.getElementById('nuevaClave');
    const passwordInput2 = document.getElementById('confirmarClave');
    const togglePassword = document.getElementById('togglePassword');
    const togglePassword2 = document.getElementById('togglePassword2');

    togglePassword.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.innerHTML = '<i class="ti ti-eye"></i>';
        } else {
            passwordInput.type = 'password';
            togglePassword.innerHTML = '<i class="ti ti-eye-off"></i>';
        }
    });

    togglePassword2.addEventListener('click', function() {
        if (passwordInput2.type === 'password') {
            passwordInput2.type = 'text';
            togglePassword2.innerHTML = '<i class="ti ti-eye"></i>';
        } else {
            passwordInput2.type = 'password';
            togglePassword2.innerHTML = '<i class="ti ti-eye-off"></i>';
        }
    });
</script>
<style>
    .checklist-box{
        font-size: 0.85rem;
        color: #6e6b7b;
        font-size: 12px;
        line-height: 12px;
        background: #296bef17;
    }
    /* Estilos base */
    .checklist {
        list-style: none;
    }

    .checklist li {
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        margin-bottom: 4px;
    }

    /* Estado por defecto: El BULLET */
    .checklist li::before {
        content: "\2022"; /* Código Unicode de un punto (bullet) */
        color: #b9b9c3;   /* Color gris claro para el punto */
        font-weight: bold;
        display: inline-block; 
        width: 20px;      /* Espacio fijo para que el texto no se mueva */
        font-size: 1.2rem;
    }

    /* Estado cuando se cumple la validación */
    .checklist li.valid {
        color: #28c76f !important; /* Verde Bootstrap/Tabler */
    }

    /* Insertar el icono de flechita dinámicamente */
    .checklist li.valid::before {
        content: "\2713"; /* Código Unicode del check (visto) */
        font-weight: bold;
        margin-right: 8px;
        color: #28c76f !important;
    }
</style>
@endsection