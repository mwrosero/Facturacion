<?php

namespace App\Models;

use session;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veris extends Model
{
    use HasFactory;
    //QkFDS0VORFBIQU5UT006Q2xAdmUxMjM0 -> QkFDS0VORFBIQU5UT006UGhAbnQwbVQzJHQjMjAyNSE=
    //DEV
    public const BASE_URL = 'https://api-phantomx.veris.com.ec';
    public const BASE_WAR = 'digitalestest';
    public const FACTURACION_WAR = 'seguridadtest';
    public const FACTURACION_WAR_DESA = 'seguridad';
    public const BASE_WAR_AI = 'agents-ai';
    public const CANAL_ORIGEN = 'MVE_CMV';
    public const CANAL_ORIGEN_EXTERNAL = 'VER_CMV';
    public const CANAL_ORIGEN_EXTERNAL_PARAMI = 'VER_PMF';
    public const APPLICATION = 'UEhBTlRPTVhfQkFDS0VORA==';//UEhBTlRPTVhfRU1QUkVTQVJJQUw=
    public const APPLICATION_FARMACIA = 'UEhBTlRPTVhfV0VC';
    public const IDORGANIZACION = 'adf4e264-cd20-4653-9a44-025b13050992';
    public const IDORGANIZACIONRESULTADOSLAB = '365509c8-9596-4506-a5b3-487782d5876e';
    public const URL_KUSHKI = 'https://api-uat.kushkipagos.com';
    public const KUSHKI_MERCHANT_ID = '10000003012872942409151942277385';
    public const KUSHKI_PRIVATE_MERCHANT_ID = '10000003012852139010151942277385';
    public const IS_KUSHKI_TEST_ENVIRONMENT = true;
    public const ENVIRONMENT_NUVEI = "stg";
    public const TEST_ENVIRONMENT_KUSHKI = true;
    public const AMPLITUDE = "1cbd8baed97a6c8abf6b8e398b77cf6f";
    public const BASICAUTHDIGITALES = 'd3NhcHBjZW50cmljbzpDQVM1Nzg5Yjg2TWRyNUMzbnRyMWMw';
    public const BASICAUTHFACTURACION = 'QkFDS0VORFBIQU5UT006UGhAbnQwbVQzJHQjMjAyNSE=';
    public const BASICAUTHFACTURACIONDESARROLLO = 'YmFja2VuZHBoYW50b206QmFja1BAbnRoMG1QQHNzMjAyMQ==';
    public const NEMONICO_FLUJO_PAGO = 'PRE_TRANSACCIONES';
    public const NEMONICO_FARMACIA = 'FARMACIA_DOMICILIO';
    public const NEMONICO_VUA = 'LIQUIDACION_VAP';
    public const URL_EPI = 'http://ecstest.veris.com.ec/Verisrest/v1/formularioepi1';
    public const BASICAUTHEPI = 'd3Nmb3JtdWxhcmlvZXBpMTpDQVM1Nzg5Yjg2TWRyNUYwcm11bGFyMTAzcGkxKg==';
    public const CONTIENE_DESARROLLO = false;
    public const API_KEY_GOOGLE_MAP = 'AIzaSyCvKhNY5DAACMCU8gAY1AbJiaqg3bTo2jc';

    //PROD 
    // public const BASE_URL = 'https://api.phantomx.com.ec';
    // public const BASE_WAR = 'digitales';
    // public const FACTURACION_WAR = 'seguridad';
    // public const BASE_WAR_AI = 'agents-ai';
    // public const CANAL_ORIGEN = 'MVE_CMV';
    // public const CANAL_ORIGEN_EXTERNAL = 'VER_CMV';
    // public const CANAL_ORIGEN_EXTERNAL_PARAMI = 'VER_PMF';
    // public const APPLICATION = 'UEhBTlRPTVhfQkFDS0VORA==';
    // public const APPLICATION_FARMACIA = 'UEhBTlRPTVhfV0VC';
    // public const IDORGANIZACION = '365509c8-9596-4506-a5b3-487782d5876e';
    // public const IDORGANIZACIONRESULTADOSLAB = '365509c8-9596-4506-a5b3-487782d5876e';
    // public const URL_KUSHKI = 'https://api.kushkipagos.com';
    // public const KUSHKI_MERCHANT_ID = '1012311620855990918315314280226';
    // public const KUSHKI_PRIVATE_MERCHANT_ID = '1012311620856084913415314280226';
    // public const IS_KUSHKI_TEST_ENVIRONMENT = false;
    // public const ENVIRONMENT_NUVEI = "prod";
    // public const TEST_ENVIRONMENT_KUSHKI = false;
    // public const AMPLITUDE = "93127ac840f734cdcc8bf469f8bc95d5";
    // public const BASICAUTHDIGITALES = 'd3NhcHBjZW50cmljbzpDQVM1Nzg5Yjg2TWRyNUMzbnRyMWMw';
    // public const BASICAUTHFACTURACION = 'YmFja2VuZHBoYW50b206QmFja1BAbnRoMG1QQHNzMjAyMQ==';
    // public const NEMONICO_FLUJO_PAGO = 'PRE_TRANSACCIONES';
    // public const NEMONICO_FARMACIA = 'FARMACIA_DOMICILIO';
    // public const NEMONICO_VUA = 'LIQUIDACION_VAP';
    // public const URL_EPI = 'https://phantom-wsexternos.phantomx.com.ec/Verisrest/v1/formularioepi1';
    // public const BASICAUTHEPI = 'd3Nmb3JtdWxhcmlvZXBpMTpDQVM1Nzg5Yjg2TWRyNUYwcm11bGFyMTAzcGkxKg==';
    // public const CONTIENE_DESARROLLO = false;
    // public const API_KEY_GOOGLE_MAP = 'AIzaSyCvKhNY5DAACMCU8gAY1AbJiaqg3bTo2jc';

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

        if( isset($config['basic']) ){
            $header[] = 'Authorization: Basic ' . $config['basic'];
            $header[] = 'Content-Type: application/json';
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

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