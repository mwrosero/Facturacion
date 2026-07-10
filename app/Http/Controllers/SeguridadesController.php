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
        $info = Session::get('userData');
        return view('seguridades.login')->with('accessToken',$this->getTokenExternalDigitales());
    }

    public function autenticar(Request $request){
        $data = $request->all();
        $numeroIdentificacion = $data['numeroIdentificacion'];
        $password = $data['password'];

        $method = '/'.Veris::BASE_WAR.'/v1/seguridad/login';
        $res =  Http::withOptions([
                    'verify' => false, // Desactivar verificación de certificados
                ])->withHeaders([
                    'Application' => Veris::APPLICATION,
                    'Authorization' => 'Basic '.base64_encode(strtoupper($numeroIdentificacion) .":". $password),
                ])->post(Veris::BASE_URL.$method);
        
        $response = json_decode($res->body());
        // dd($response);
        if($response->code == 200){
            if (!is_null($response->data->codigoActivacion)) {
                Session::put('userDataTmp', $response->data);
                return redirect('/activar-cuenta');
            }else{
                Session::put('userData', $response->data);
                return redirect('/');
            }
        }else{
            $message = $response->message;
        }
        if(isset($message)){
            session()->flash('alert', $message);
            session()->flash('numeroIdentificacion', strtoupper($numeroIdentificacion));
            return redirect('/login');
        }
    }

    public function activarCuentaView(){
        if (Session::has('userDataTmp')) {
            return view('seguridades.activar_cuenta')
                ->with('tipoIdentificacion',Session::get('userDataTmp')->codigoTipoIdentificacion)
                ->with('numeroIdentificacion',Session::get('userDataTmp')->numeroIdentificacion)
                ->with('mail',Session::get('userDataTmp')->mail)
                ->with('accessToken',$this->getTokenExternalDigitales());;
        }else{
            return redirect('/login');
        }
    }

    public function activarCuenta(Request $request){
        $data = $request->all();
        $codigoTipoIdentificacion = Session::get('userDataTmp')->codigoTipoIdentificacion;
        $numeroIdentificacion = Session::get('userDataTmp')->numeroIdentificacion;
        // dd($data['codigoActivacion']);

        $method = '/'.Veris::BASE_WAR.'/v1/seguridad/cuenta/activacion';

        $response = Veris::call([
            'endpoint' => Veris::BASE_URL.$method,
            'data'     => ["tipoIdentificacion" => $codigoTipoIdentificacion, "numeroIdentificacion" => $numeroIdentificacion, "codigoActivacion" => $data['codigoActivacion'],"canalOrigenDigital" => Veris::CANAL_ORIGEN],
            'method'   => 'POST'
        ]);

        if($response->code == 200){
            Session::put('userData', Session::get('userDataTmp'));
            Session::forget('userDataTmp');
            return redirect()->route('home');
        }else{
            $message = $response->message;
            session()->flash('alert', $message);
            return view('seguridades.activar_cuenta')
                ->with('tipoIdentificacion',Session::get('userDataTmp')->codigoTipoIdentificacion)
                ->with('numeroIdentificacion',Session::get('userDataTmp')->numeroIdentificacion)
                ->with('mail',Session::get('userDataTmp')->mail)
                ->with('accessToken',$this->getTokenExternalDigitales());;
        }
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
}
