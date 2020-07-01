<?php

namespace App\Utils;
use App\Models\User;
use App\Utils\Token;

use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Factory\AppFactory;
use Slim\Exception\NotFoundException;

class Funciones{

public function validar($legajo)
{
    if($legajo >= 1000 && $legajo <= 2000)
    {  
        return true;
    }
    else{
        return false;
    }

}

    public function validarTipo($tipo)
    {
        if($tipo==1 || $tipo==2 || $tipo==3)
        {  
            return true;
        }
        else{
            return false;
        }
    
    }

public function ValidarLogin($email,$clave)
{
     

    $lista=(User::all());
        
     foreach($lista as $value)
     {
         if($value->email==$email && $value->clave==$clave)
         {
            
             $token= new Token;
             
             echo json_encode($token->encodetoken($email,$clave));

             return "Login exitoso";
             break;
         }       
     }
     return "Clave o email erroneos";
}

public function ValidarAdmin($toko)
{
    $email=$toko->email;
    
     $users = Capsule::table('users')
    ->where('email', '=', $email)
    ->select(['tipo_id'])
    ->get();
     
    if($users[0]->tipo_id==3){
        return true;
    }else{
       return false;
    }
  
}

public function traerId($toko)
{
    $email=$toko->email;
    
     $users = Capsule::table('usuarios')
    ->where('email', '=', $email)
    ->select(['id'])
    ->get();
     
    $id=$users[0]->id;
     return $id; 
  
}


public function traerMascota($toko)
{
    $email=$toko->email;
    
     $users = Capsule::table('usuarios')
    ->where('email', '=', $email)
    ->join('mascotas', 'mascotas.cliente_id', '=', 'usuarios.id')
    ->select(['mascotas.id'])
    ->get();
    
    $h=$users[0]->id;
    
     return $h; 
  
}



public function checkEmail($email)
{
    $lista=(Usuario::all());
        
    foreach($lista as $value)
    {
        if($value->email==$email)
        {
            return false;
            break;
        }       
    }
    return true;
}

public function traerTipo($toko)
{
    $users = Capsule::table('users')
    ->where('email', '=', $toko->email)
    ->select(['tipo_id'])
    ->get();
    
     $h=$users[0]->tipo_id;
     
     return $h; 
}

public function validarProfe($profe)
{
    
    
     $profe = Capsule::table('users')
    ->where('id', '=', $profe)
    ->select(['tipo_id'])
    ->get();
     
    if($profe[0]->tipo_id==2){
        return true;
    }else{
       return false;
    }
  
}

public function validarAlumno($toko)
{
    $email=$toko->email;
    
     $users = Capsule::table('users')
    ->where('email', '=', $email)
    ->select(['tipo_id'])
    ->get();
     
    if($users[0]->tipo_id==1){
        return true;
    }else{
       return false;
    }
  
}

public function validarIdAlumno($id)
{
    
    
     $profe = Capsule::table('users')
    ->where('id', '=', $id)
    ->select(['tipo_id'])
    ->get();
     
    if($profe[0]->tipo_id==1){
        return true;
    }else{
       return false;
    }
  
}



}
?>