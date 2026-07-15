<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use App\Models\Veris;
use App\Http\Controllers\SeguridadesController;

class FacturaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function externalDashboard(){
        $user = Session::get('user_external');
        $seguridadesController = app(SeguridadesController::class);
        return view('external.dashboard')
            ->with('accessToken',$seguridadesController->getTokenExternalFacturacion())
            ->with('codigoUsuarioPortal',$user->codigoUsuario)
            ->with('tokenPortalUsuario',$user->tokenPortal);
    }
}
