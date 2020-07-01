<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Utils\Funciones;
use App\Models\Materia;
use App\Models\Inscripto;
use App\Utils\Token;

use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Factory\AppFactory;
use Slim\Exception\NotFoundException;




class MateriaController{

   
    public function add(Request $request, Response $response, $args)
    {
        
            $materia = new Materia;
            $body= $request->getParsedBody();


            $header = getallheaders();
            $mitoken=$header["token"] ?? " ";
            $toko=Token::decodeToken($mitoken);

          if(Funciones::validarAdmin($toko)){

            $materia->materia = $body["materia"]??"";
            $materia->cuatrimestre = $body["cuatrimestre"]??"";
            $materia->vacantes = $body["vacante"]??"";
            $materia->profesor_id = $body["profesor"]??"";
         
           
            try {   

             $rta = json_encode(array("ok" => $materia->save()));
             
            } catch (\Throwable $th) {
                $rta="Error en la carga";
            } 
        }else{
            $rta="Debe ser Admin para entrar";
        } 
    
        $response->getBody()->write($rta);

        return $response;
    }

    public function verMateria(Request $request, Response $response, $args)
    {

        $header = getallheaders();
        $mitoken=$header["token"] ?? " ";
        $toko=Token::decodeToken($mitoken); 
        
        $tipo=Funciones::traerTipo($toko);

    if($tipo==1){

        $id=$args["id"];
        $users = Capsule::table('materias')
        ->get(); 
    
       $response->getBody()->write(json_encode($users));
       return $response;

    }

    if($tipo==2 || $tipo==3 )
    {
        echo "Sos Profe o Admin";
        $idp=$args["id"];
        $users = Capsule::table('materias')
        ->where('profesor_id', '=', $idp)
        ->join('inscriptos', 'materias.id', '=', 'inscriptos.materia_id')
        ->join('users', 'users.id', '=', 'inscriptos.alumno_id')
        ->select(['materia'])
        ->get(); 
    
       
       $response->getBody()->write(json_encode($users));
       return $response;

    }

 
    }

    public function addProfe(Request $request, Response $response, $args)
    {
        $id=$args["id"];
        $profe=$args["profesor"];
            
            $body= $request->getParsedBody();


            $header = getallheaders();
            $mitoken=$header["token"] ?? " ";
            $toko=Token::decodeToken($mitoken);

          if(Funciones::validarAdmin($toko)){

           $materia=Materia::find($id);

           $materia->profesor_id=$profe;

         if(Funciones::validarProfe($profe)){
            try {   

                $rta = json_encode(array("ok" => $materia->save()));
                
               } catch (\Throwable $th) {
                   $rta="Error en la carga";
               } 
         }else{
             $rta="El ID ingresado debe corresponder a un profesor";
         }
            
        }else{
            $rta="Debe ser Admin para entrar";
        } 
    
        $response->getBody()->write($rta);

        return $response;
    }

    public function inscripcion(Request $request, Response $response, $args)
    {
            $id=$args["id"];
        
            $body= $request->getParsedBody();


            $header = getallheaders();
            $mitoken=$header["token"] ?? " ";
            $toko=Token::decodeToken($mitoken);

          if(Funciones::validarAlumno($toko)){

             $alumno = new Inscripto;
             $alumno->alumno_id = $id;
             $alumno->materia_id = 1;
             $alumno->date="";
           

         if(Funciones::validarIdAlumno($id)){
            try {   

                $rta = json_encode(array("ok" => $alumno->save()));
                
               } catch (\Throwable $th) {
                   $rta="Error en la carga";
               } 
         }else{
             $rta="El ID ingresado debe corresponder a un alumno";
         }
            
        }else{
            $rta="Debe ser Alumno para entrar";
        } 
    
        $response->getBody()->write($rta);

        return $response;
    }




}

?>