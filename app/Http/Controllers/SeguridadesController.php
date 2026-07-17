<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use App\Models\Veris;

class SeguridadesController extends Controller
{
    /*Login*/
    public function login(){
        $info = Session::get('user_external');
        return view('seguridades.login')->with('accessToken',$this->getTokenExternalDigitales());
    }

    public function loginVeris(Request $request){
        $data = $request->all();
        $user = strtoupper($data['numeroIdentificacion']);
        $password = $data['password'];


        $method = '/'.Veris::FACTURACION_WAR.'/v1/autenticacion/login';
        $res =  Http::withOptions([
                    'verify' => false, // Desactivar verificación de certificados
                ])->withHeaders([
                    'Application' => Veris::APPLICATION_FARMACIA,
                    'Authorization' => 'Basic '.base64_encode(strtoupper($user) .":". $password),
                ])->post(Veris::BASE_URL.$method);
        
        $response = json_decode($res->body());

        if($response->code == 200){
            switch($response->data->estadoUsuario) {
                case 'CONFIRMED':
                    
                    /*$method = '/'.Veris::FACTURACION_WAR.'/v1/usuarios/'.$response->data->secuenciaUsuario.'?tipoSucursal=TODOS';
                    $dataRoles = Veris::call([
                        'endpoint' => Veris::BASE_URL.$method,
                        'method'   => 'GET',
                        'application' => Veris::APPLICATION_FARMACIA,
                        'token'    => $response->data->idToken,
                        'data'     => $data
                    ]);
                    $roles = collect($dataRoles->data->roles);

                    $existe = $roles->contains(function ($item) {
                        return $item->codigoRol == 1121 && trim($item->nombreRol) == 'GUIA DE DESPACHO USUARIO2';
                    });*/
                    $existe = true;
                    // dump($existe);

                    if ($existe){
                        Session::put('user_veris', $response->data);
                        Session::put('accessToken', $response->data->idToken);
                        // dd($response->data->secuenciaUsuario);
                        // Session::put('roles', $dataRoles->data);
                        return redirect('/empresarial');
                    }else{
                        $message = "Usuario no dispone del ROL requerido.";
                    }
                break;
                case 'FORCE_CHANGE_PASSWORD':
                    $message = "Usuario nuevo que ingresa una clave temporal";
                break;
                case 'CHANGE_PASSWORD':
                    $message = "Usuario debe cambiar su clave porque ha pasado 'x' tiempo desde el último cambio";
                break;
                case 'RESET_REQUIRED':
                    $message = "7702057701963";
                break;
            }
            $message = $message . ' - Esto debe realizarlo en PhantomX.';
        }else{
            $message = $response->message;
        }

        if(isset($message)){
            session()->flash('mensaje', $message);
            session()->flash('user', strtoupper($user));
            return redirect('/external/farmacia/login')
                    ->with('accessToken','');
        }
    }

    public function loginExternal(Request $request){
        $data = $request->all();
        $usuario = $data['numeroIdentificacion'];
        $password = $data['password'];

        $accessToken = $this->getTokenExternalFacturacion();
        
        $method = '/'.Veris::BASE_WAR.'/v1/comprobantes/portal_usuario/login';
        // dump($accessToken);
        $response = Veris::call([
            'endpoint'  => Veris::BASE_URL.$method,
            'data'      => [
                "usuario" => $usuario, 
                "clave" => $password
            ],
            'token'     => $accessToken,
            'method'    => 'POST'
        ]);

        // echo Veris::BASE_URL.$method;
        // dd($response);
        if($response->code == 200){
            if ($response->data->estado != "A") {
                Session::put('claveActual', $password);
                Session::put('userDataTmp', $response->data);
                return redirect('/configurar-clave');
            }else{
                Session::put('user_external', $response->data);
                return redirect('/');
            }
        }else{
            $message = $response->message;
        }

        if(isset($message)){
            session()->flash('alert', $message);
            session()->flash('numeroIdentificacion', strtoupper($usuario));
            return redirect('/');
        }
    }

    public function showActualizarClave(){
        if (Session::has('userDataTmp')) {
            $accessToken = $this->getTokenExternalFacturacion();
            return view('seguridades.formulario_cambiar_clave')
                ->with('codigoUsuario',Session::get('userDataTmp')->codigoUsuario)
                ->with('numeroIdentificacion',Session::get('userDataTmp')->numeroIdentificacion)
                ->with('claveActual',Session::get('claveActual'))
                ->with('accessToken', $accessToken);
        }else if (Session::has('user_external')) {
            // Si esta logueado
            $accessToken = $this->getTokenExternalFacturacion();
            return view('seguridades.formulario_cambiar_clave')
                ->with('codigoUsuario',Session::get('user_external')->codigoUsuario)
                ->with('numeroIdentificacion',Session::get('user_external')->numeroIdentificacion)
                ->with('accessToken', $accessToken);
        }else{
            return redirect('/');
        }
    }

    public function actualizarClaveTemporalAction(Request $request){
        $data = $request->all();
        $method = '/'.Ism::WAR_SEGURIDAD.'/v1/usuarios/activacion_cuenta';
        $response = Ism::call([
            'endpoint' => Ism::BASE_URL.$method,
            //'token'    => Ism::getToken(),
            'data'     => ['usuario' => Session::get('userTmp'), 'claveTemporal' => Session::get('passwordTmp'), 'claveNueva' => $data['nuevaClave'], 'codigoGrupoUsuario' => 3],
            'method'   => 'POST'
        ]);

        if($response->code != 200){
            session()->flash('mensaje', $response->message);
            return Redirect::route('actualizarClaveTemporal');
        }

        session()->flash('mensaje', "Contraseña actualizada exitosamente.");
        return redirect()->route('login');
    }

    public function actualizarClave(Request $request){
        $data = $request->all();
        // $codigoUsuario = Session::get('userDataTmp')->codigoUsuario;
        // $numeroIdentificacion = Session::get('userDataTmp')->numeroIdentificacion;
        // dd($data);
        $accessToken = $this->getTokenExternalFacturacion();

        $method = '/'.Veris::BASE_WAR.'/v1/comprobantes/portal_usuario/cambiar_clave';

        if(Session::has('user_external')){
            $response = Veris::call([
                'endpoint' => Veris::BASE_URL.$method,
                'data'     => [
                    // "usuario" => $data['usuario'], 
                    // "claveActual" => $data['claveActual'], 
                    "claveNueva" => $data['nuevaClave'],
                    "repetirClave" => $data['confirmarClave']
                ],
                'method'   => 'POST',
                'token'    => $accessToken,
                'tokenPortalUsuario' => Session::get('user_external')->tokenPortal,
                'codigoUsuarioPortal' => Session::get('user_external')->codigoUsuario
            ]);
        }else{
            $response = Veris::call([
                'endpoint' => Veris::BASE_URL.$method,
                'data'     => [
                    "usuario" => $data['usuario'], 
                    "claveActual" => $data['claveActual'], 
                    "claveNueva" => $data['nuevaClave'],
                    "repetirClave" => $data['confirmarClave']
                ],
                'method'   => 'POST',
                'token'    => $accessToken,
                'codigoUsuarioPortal' => $data['usuario']
            ]);
        }

        if($response->code != 200){
            session()->flash('mensaje', $response->message);
            if (Session::has('user_external')){
                return redirect('/actualizar-clave');
            }else{
                return redirect('/configurar-clave');
            }
        }

        session()->flash('mensaje', "Contraseña actualizada exitosamente.");
        if (Session::has('user_external')){
            return redirect('/configurar-clave');
        }else{
            return redirect()->route('login');
        }

    }

    public function registrarCuenta(){
        return view('seguridades.registrar_cuenta')
                ->with('accessToken',$this->getTokenExternalDigitales());
    }

    /*Formulario de Olvide clave*/
    public function showRecuperar(){
        return view('seguridades.recuperar_clave');
    }

    public function sendRecuperar(Request $request){
        $data = $request->all();
        $accessToken = $this->getTokenExternalFacturacion();

        $method = '/'.Veris::BASE_WAR.'/v1/comprobantes/portal_usuario/recuperar_clave';
        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'data'     => [
                "numeroIdentificacion" => $data['numeroIdentificacion'],
            ],
            'method'   => 'POST',
            'token'    => $accessToken
        ]);
        // dd($response);
        if($response->code != 200){
            session()->flash('mensaje', $response->message);
            session()->flash('numeroIdentificacion', $data['numeroIdentificacion']);
            return redirect('/recuperar-clave');
        }

        session()->flash('mensaje', $response->message);
        return redirect('/');

    }

    /*Logout*/
    public function logout(){
        //dd(0);
        // Session::forget('user');
        $type = (Session::has('user_external')) ? '/' : '/empresarial';
        Session::flush();
        // return redirect()->route('login');
        return redirect($type);
    }

    public function getTokenExternalDigitales(){
        $token = session('accessTokenDigitales', null);

        if( $token !== null ){
            //return $token;
        }

        $method = '/'.Veris::BASE_WAR.'/v1/seguridad/login?canalOrigen='.Veris::CANAL_ORIGEN_EXTERNAL;
        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'basic' => Veris::BASICAUTHDIGITALES,
            'method'   => 'POST'
        ]);
        // dd($response->data->tokenPush);
        session(['accessTokenDigitales' => $response->data->tokenPush]);
        return $response->data->tokenPush;
    }

    public function getTokenExternalFacturacion($esDesarrollo = false){
        $token = session('accessTokenFacturacion', null);

        if( $token !== null ){
            //return $token;
        }

        if($esDesarrollo){
            $nameWar = Veris::FACTURACION_WAR_DESA;
            $basic = Veris::BASICAUTHFACTURACIONDESARROLLO;
        }else{
            $nameWar = Veris::FACTURACION_WAR;
            $basic = VERIS::BASICAUTHFACTURACION;
        }

        $method = '/'.$nameWar.'/v1/autenticacion/login';
        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'basic' => $basic,
            'method'   => 'POST',
            'tokenDesarrollo' => $esDesarrollo
        ]);
        // echo $basic;
        // dump(Veris::BASE_URL.$method);
        // dd($response);
        session(['accessTokenFacturacion' => $response->data->idToken]);
        return $response->data->idToken;
    }
}
