<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuariosController;
use App\Middlewares\BeforeMiddlewares;
use App\Controllers\MateriaController;

             
    return function($app){
        
        $app->group('/usuario', function (RouteCollectorProxy $group) {
            $group->post('[/]', UsuariosController::class . ':add');  
        });

        $app->group('/login', function (RouteCollectorProxy $group) {
            $group->post('[/]', UsuariosController::class . ':login'); 
        });

        $app->group('/materias', function (RouteCollectorProxy $group) {
            $group->post('[/]', MateriaController::class . ':add')->add(BeforeMiddlewares::class);; 
            $group->get('/{id}', MateriaController::class . ':verMateria')->add(BeforeMiddlewares::class);
            $group->put('/{id}/{profesor}', MateriaController::class . ':addProfe')->add(BeforeMiddlewares::class);
            $group->put('/{id}', MateriaController::class . ':inscripcion')->add(BeforeMiddlewares::class);
        });

      

      
    };
    

    
    
    
    