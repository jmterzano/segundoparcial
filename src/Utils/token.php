<?php
namespace App\Utils;

use \Firebase\JWT\JWT;
class Token{

    public static function encodeToken($email,$clave)
    {
        $key = "llave";
        $payload = array(
        "iss" => "http://example.org",
        "aud" => "http://example.com",
        "iat" => 1356999524,
        "nbf" => 1357000000,
        "email"=>$email,
        "clave"=>$clave
          );

        try {   
             
            return JWT :: encode($payload,$key);
            
        } catch (\Throwable $th) {
            return "Error";
        }
    }

    public static function decodeToken($token)
    {
        $key = "llave";
        try {
            
            $decode = JWT::decode($token, $key, array('HS256'));
            return $decode;

        } catch (\Throwable $th) {
    
           return false;
        }

    
    }



}
?>