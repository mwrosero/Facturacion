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

    public function loginExternal(Request $request){
        $data = $request->all();
        $usuario = $data['numeroIdentificacion'];
        $password = $data['password'];

        $method = '/'.Veris::BASE_WAR.'/v1/comprobantes/portal_usuario/login';
        
        $accessToken = $this->getTokenExternalFacturacion();

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

    public function showActualizarAfterLogin(){
        if (Session::has('userDataTmp')) {
            $accessToken = $this->getTokenExternalFacturacion();
            return view('seguridades.activar_cuenta')
                ->with('codigoUsuario',Session::get('userDataTmp')->codigoUsuario)
                ->with('numeroIdentificacion',Session::get('userDataTmp')->numeroIdentificacion)
                ->with('claveActual',Session::get('claveActual'))
                ->with('accessToken', $accessToken);
        }else{
            return redirect('/login');
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

    public function activarCuenta(Request $request){
        $data = $request->all();
        // $codigoUsuario = Session::get('userDataTmp')->codigoUsuario;
        // $numeroIdentificacion = Session::get('userDataTmp')->numeroIdentificacion;
        // dd($data['codigoActivacion']);
        $accessToken = $this->getTokenExternalFacturacion();

        $method = '/'.Veris::BASE_WAR.'/v1/comprobantes/portal_usuario/cambiar_clave';

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

        // dd($response);

        if($response->code != 200){
            session()->flash('mensaje', $response->message);
            return redirect('/configurar-clave');
        }

        session()->flash('mensaje', "Contraseña actualizada exitosamente.");
        return redirect()->route('login');

        // if($response->code == 200){
        //     Session::put('user_external', Session::get('userDataTmp'));
        //     Session::forget('userDataTmp');
        //     return redirect()->route('home');
        // }else{
        //     $message = $response->message;
        //     session()->flash('alert', $message);
        //     return view('seguridades.activar_cuenta')
        //         ->with('tipoIdentificacion',Session::get('userDataTmp')->codigoTipoIdentificacion)
        //         ->with('numeroIdentificacion',Session::get('userDataTmp')->numeroIdentificacion)
        //         ->with('mail',Session::get('userDataTmp')->mail)
        //         ->with('accessToken',$this->getTokenExternalDigitales());;
        // }
    }

    public function registrarCuenta(){
        return view('seguridades.registrar_cuenta')
                ->with('accessToken',$this->getTokenExternalDigitales());
    }

    /*Formulario de Olvide clave*/
    public function olvideClave(){
        return view('seguridades.olvide_clave')
                ->with('accessToken',$this->getTokenExternalDigitales());
    }

    /*public function recuperarClave(Request $request){
        return view('seguridades.reestablecer_clave');
    }*/

    public function reestablecerClave($params){
        return view('seguridades.reestablecer_clave')
            ->with('params',$params)
            ->with('accessToken',$this->getTokenExternalDigitales());;
    }

    /*Logout*/
    public function logout(){
        //dd(0);
        // Session::forget('user');
        Session::flush();
        return redirect()->route('login');
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
