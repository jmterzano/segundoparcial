<?php
namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Utils\Token;


class BeforeMiddlewares
{
      /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
      
        $header = getallheaders();
        $mitoken=$header["token"] ?? " ";
     

        if(Token::decodeToken($mitoken)){
          $response=$handler->handle($request);
          $existingContent=(string)$response->getBody();
          $resp= new Response();
          $resp->getBody()->write($existingContent);
          return $resp;
          
             
      }else{
       /* $response= new Response();
        throw new \Slim\Exception\HttpForbiddenException($request);
        return $response->withStatus(403); */
        $resp= new Response();
        $resp->getBody()->write("Token incorrecto");
        return $resp;
      }
      
    }

}