<?php

require_once("./vendor/autoload.php");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenHelper
{

    /**
     * Funcion que genera un JWT si los datos que dio el user son correctos
     * @param array $user_data Arreglo asociativo con los datos a verificar
     * @return mixed Retorna el token de haberse logueado correctamente, o devuelve false en caso de haber un error
     */
    public static function generate($user)
    {
        $payload = [
            "iss" => "HarmonyHub",
            "exp" => strtotime('now') + (3600 * 24),
            "data" => [
                "name" => $user->name,
                "role" => $user->role
            ]
        ];
        $token = JWT::encode($payload, ENCODE_KEY, "HS256");
        return $token;
    }

        /**
     * Funcion que verifica si un token es valido y que el usuario portador del token tiene el rol que queremos que tenga
     * @param string $token Token a verificar
     * @param string $desired_role El rol que queremos que tenga el usuario portador del token, por default es 'admin'
     * @return boolean|Exception Retorna true si el token es correcto y el rol coincide con el deseado, en caso de error retorna una excepcion
     */
    public static function verify($token, $desired_role = 'admin')
    {
        try {
            // Intenta decodificar
            $decoded_token = JWT::decode($token, new Key(ENCODE_KEY, "HS256"));
        
            // Verifica si el token ha expirado
            if ($decoded_token->exp < strtotime('now')) {
                // Token caducado
                throw new Exception("El token provisto ha vencido", 401);
            }
            if(!empty($decoded_token->nbf) and $decoded_token->nbf > strtotime('now')){
                //Verifica si el token tiene una fecha de uso minima posterior a ahora
                throw new Exception("El token provisto no puede ser usado hasta $decoded_token->nbf (formato de tiempo unix)",400);
            }
            if($decoded_token->data->role !== $desired_role)
                throw new Exception("No tiene los permisos suficientes para realizar esta accion", 401);
            
        } catch (Exception $e) {
            // Error en la verificación del token
            return $e;
        }
        
        return $decoded_token->data->role == $desired_role;
    }

    /**
     * Funcion que devuelve el token incluido en los Headers de la request
     * @param array $user_data Arreglo asociativo con los datos a verificar
     * @return mixed Retorna el token de haberse logueado correctamente, o devuelve false en caso de haber un error
     */
    public static function getTokenFromHeaders(){
        $data= apache_request_headers();
        if(empty($data["Authorization"]))
            return false;
        $data = explode(" ", $data['Authorization']);
        return $data[1];
    }
}
