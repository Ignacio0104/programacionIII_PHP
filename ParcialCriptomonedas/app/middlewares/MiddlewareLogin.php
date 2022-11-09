<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class MiddlewareLogin{
    public function __invoke(Request $request,RequestHandler $handler) : Response
    {
        $response = $handler->handle($request);
        $existingContent= (string)$response->getBody();
        var_dump($existingContent);
       if(strcmp($existingContent,"Usuario logueado")==0)
        {
            $response = new Response();
            $response->getBody()->write("Verificado");
        }
        return $response;
    }
}
?>