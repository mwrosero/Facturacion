<?php

namespace App\Models;

use session;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veris extends Model
{
    use HasFactory;
    //QkFDS0VORFBIQU5UT006Q2xAdmUxMjM0 -> QkFDS0VORFBIQU5UT006UGhAbnQwbVQzJHQjMjAyNSE=
    //DEV https://comprobantes.veris.com.ec/
    // public const BASE_URL = 'https://api-phantomx.veris.com.ec';
    // public const BASE_WAR = 'financiero';
    // public const FACTURACION_WAR = 'seguridad';
    // public const BASE_WAR_GENERAL = 'generaltest';
    // public const BASE_WAR_AI = 'agents-ai';
    // public const CANAL_ORIGEN = 'MVE_CMV';
    // public const CANAL_ORIGEN_EXTERNAL = 'VER_CMV';
    // public const CANAL_ORIGEN_EXTERNAL_PARAMI = 'VER_PMF';
    // public const APPLICATION = 'UEhBTlRPTVhfQkFDS0VORA==';
    // public const APPLICATION_PHX = 'UEhBTlRPTVhfV0VC';
    // public const IDORGANIZACION = '365509c8-9596-4506-a5b3-487782d5876e';
    // public const IDORGANIZACIONRESULTADOSLAB = '365509c8-9596-4506-a5b3-487782d5876e';
    // public const BASICAUTHDIGITALES = 'd3NhcHBjZW50cmljbzpDQVM1Nzg5Yjg2TWRyNUMzbnRyMWMw';
    // public const BASICAUTHFACTURACION = 'QkFDS0VORFBIQU5UT006UGhAbnQwbUQzdiMyNSE=';

    //DEV https://facturacion.akold.com/
    // public const BASE_URL = 'https://api-phantomx.veris.com.ec';
    // public const BASE_WAR = 'financierotest';
    // public const FACTURACION_WAR = 'seguridadtest';
    // public const BASE_WAR_GENERAL = 'generaltest';
    // public const BASE_WAR_AI = 'agents-ai';
    // public const CANAL_ORIGEN = 'MVE_CMV';
    // public const CANAL_ORIGEN_EXTERNAL = 'VER_CMV';
    // public const CANAL_ORIGEN_EXTERNAL_PARAMI = 'VER_PMF';
    // public const APPLICATION = 'UEhBTlRPTVhfQkFDS0VORA==';
    // public const APPLICATION_PHX = 'UEhBTlRPTVhfV0VC';
    // public const IDORGANIZACION = 'adf4e264-cd20-4653-9a44-025b13050992';
    // public const IDORGANIZACIONRESULTADOSLAB = '365509c8-9596-4506-a5b3-487782d5876e';
    // public const BASICAUTHDIGITALES = 'd3NhcHBjZW50cmljbzpDQVM1Nzg5Yjg2TWRyNUMzbnRyMWMw';
    // public const BASICAUTHFACTURACION = 'QkFDS0VORFBIQU5UT006UGhAbnQwbVQzJHQjMjAyNSE=';

    //PROD 
    public const BASE_URL = 'https://api.phantomx.com.ec';
    public const BASE_WAR = 'financiero';
    public const FACTURACION_WAR = 'seguridad';
    public const BASE_WAR_GENERAL = 'general';
    public const BASE_WAR_AI = 'agents-ai';
    public const CANAL_ORIGEN = 'MVE_CMV';
    public const CANAL_ORIGEN_EXTERNAL = 'VER_CMV';
    public const CANAL_ORIGEN_EXTERNAL_PARAMI = 'VER_PMF';
    public const APPLICATION = 'UEhBTlRPTVhfQkFDS0VORA==';
    public const APPLICATION_PHX = 'UEhBTlRPTVhfV0VC';
    public const IDORGANIZACION = '365509c8-9596-4506-a5b3-487782d5876e';
    public const IDORGANIZACIONRESULTADOSLAB = '365509c8-9596-4506-a5b3-487782d5876e';
    public const BASICAUTHDIGITALES = 'd3NhcHBjZW50cmljbzpDQVM1Nzg5Yjg2TWRyNUMzbnRyMWMw';
    public const BASICAUTHFACTURACION = 'YmFja2VuZHBoYW50b206QmFja1BAbnRoMG1QQHNzMjAyMQ==';

    static function call(Array $config)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $config['endpoint']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // METHOD
        if( $config['method'] == 'POST' ){
            curl_setopt($ch, CURLOPT_POST, 1);
        }else if( $config['method'] == 'GET' || $config['method'] == 'PUT' ){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $config['method']);
        }

        $header = [];
        if(isset($config['TokenPush'])){
            $header[] = 'TokenPush: ' . $config['TokenPush'];
        }
        
        if(isset($config['application'])){
            $header[] = 'application: ' . $config['application'];
        }else{
            $header[] = 'application: ' . self::APPLICATION;
        }
        
        // $header[] = 'idOrganizacion: ' . self::IDORGANIZACION;
        if(isset($config['tokenDesarrollo']) && $config['tokenDesarrollo']){
            $header[] = 'idOrganizacion: ' . self::IDORGANIZACIONRESULTADOSLAB;
        }else{
            $header[] = 'idOrganizacion: ' . self::IDORGANIZACION;
        }

        if(isset($config['tokenKushki']) && $config['tokenKushki']){
            $header[] = 'Private-Merchant-Id: ' . self::KUSHKI_PRIVATE_MERCHANT_ID;
        }

        $tokenBearerSetted = false;

        // AUTH
        // if( isset($config['token']) && !isset($config['data'])){
        if( isset($config['token']) ){
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $config['token'] ));
            $header[] = 'Authorization: Bearer ' . $config['token'];
            $tokenBearerSetted = true;
        }

        // POST DATA
        if( isset($config['data']) && ($config['method'] == 'POST' || $config['method'] == 'PUT' ) ){
            $data_serialized = json_encode($config['data']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_serialized);
            
            $header[] = 'Content-Type: application/json';
            $header[] = 'Content-Length: ' . strlen($data_serialized);
            $header[] = 'content-language: es';
            
            if( isset($config['token']) && !$tokenBearerSetted){
                $header[] = 'Authorization: Bearer ' . $config['token'];
            }
        }

        if(isset($config['codigoUsuarioPortal'])){
            $header[] = 'codigoUsuarioPortal: ' . $config['codigoUsuarioPortal'];
        }

        if(isset($config['tokenPortalUsuario'])){
            $header[] = 'tokenPortalUsuario: ' . $config['tokenPortalUsuario'];
        }

        if( isset($config['basic']) ){
            $header[] = 'Authorization: Basic ' . $config['basic'];
            $header[] = 'Content-Type: application/json';
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // dump($header);

        // LOGIN
        if( isset($config['username']) && isset($config['password'])){
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $config['username'].":".$config['password']);
        }

        // dump($header);
        
        // API CALL
        try{
            // logger()->debug('Petición API', [
            //     'url' => $config['endpoint'],
            //     'method' => $config['method'],
            //     'headers' => $header,
            //     'body' => $config['data'] ?? null,
            // ]);

            $result = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);
            // if ($status_code >= 400) {
            //     dd([
            //         'status' => $status_code,
            //         'raw_response' => $result,
            //         'json_decoded' => json_decode($result),
            //         'json_error' => json_last_error_msg(),
            //     ]);
            // }

            //Para pagos con kushki
            if(isset($config['tokenKushki']) && $config['tokenKushki']){
                $response = [
                    'data' => gettype($result) === 'string' ? json_decode($result, true) : $result,
                    'status_code' => $status_code,
                ];

                return $response;
            }
        }
        catch(\Exception $e){
            $result = [ 'error' => 'Falla en la llamada', ];
        }

        // RETURN DATA
        if( gettype($result) === 'string' )
            return json_decode($result);

        return $result;
    }

    /*
    * getToken
    * ----------------------------------------------
    * Peticion al webservice de ISM para obtener el token
    * de acceso para las peticiones CURL. Esto se debe
    * ejecutar una sola vez por sessión.
    * ----------------------------------------------
    */
    static function getToken()
    {
        $token = session('accessToken', null);

        /*if( $token !== null ){
            return $token;
        }*/


        $username = '';
        $password = '';
        $method = '/generaToken';
        //dump(self::BASE_URL.$method);
        $result = self::call([
            'endpoint' => self::BASE_URL.$method,
            'method'   => 'POST',
            'username' => $username,
            'password' => $password
        ]);
        /*dump(self::BASE_URL.$method);
        dd($result);*/
        /*$curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => self::BASE_URL.$method,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic d3N3ZWJhdXJvcmE6bjNVRTYwQHMzUnYxYzEwQFczYkF1UjByYQ=='
          ),
        ));

        $result = curl_exec($curl);*/

        session(['accessToken' => $result->accesToken]);
        return $result->accesToken;
    }

    static function getTokenDigitales()
    {
        $token = session('accessTokenDigitales', null);

        if( $token !== null ){
            return $token;
        }

        $username = '';
        $password = '';
        $method = '/v1/seguridad/login?canalOrigen=MVE_CMV';
        //dump(self::BASE_URL.$method);
        $result = self::call([
            'endpoint' => self::BASE_URL.$method,
            'method'   => 'POST',
            'username' => $username,
            'password' => $password
        ]);
        /*dump(self::BASE_URL.$method);
        dd($result);*/
        /*$curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => self::BASE_URL.$method,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic d3N3ZWJhdXJvcmE6bjNVRTYwQHMzUnYxYzEwQFczYkF1UjByYQ=='
          ),
        ));

        $result = curl_exec($curl);*/

        session(['accessTokenDigitales' => $result->accesToken]);
        return $result->accesToken;
    }

}