<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Utils\Funciones;
use App\Models\User;



class UsuariosController{

    public function add(Request $request, Response $response, $args)
    {
        $usuario = new User;
        $body= $request->getParsedBody();
        
        $legajo=$body["legajo"]??"";
        $tipo=$body["tipo"]??"";

        if(Funciones::validar($legajo))
        {  
            if(Funciones::validarTipo($tipo)){


                $usuario->email = $body["email"]??"";
                $usuario->nombre = $body["nombre"]??"";
                $usuario->clave =$body["clave"]??"";
                $usuario->tipo_id = $body["tipo"]??"";
                $usuario->legajo = $legajo;
    
                try {   
                 
                    $rta = json_encode(array("ok" => $usuario->save()));
                    
                } catch (\Throwable $th) {
                    $rta="error";
                } 
              
               

            }else{
                $rta="Tipo debe ser 1, 2 o 3";
            }
      
         
        }else{
           $rta="Legajo debe ser entre 1000 y 2000";
        }
    
        $response->getBody()->write($rta);

        return $response;
    }

    public function login(Request $request, Response $response, $args)
    {
       
        $body= $request->getParsedBody();
        
        $email=$body["email"]??"";
        $clave=$body["clave"]??"";

        $rta=Funciones::ValidarLogin($email,$clave);
        $response->getBody()->write($rta);

        return $response;
    }

    


}

?>