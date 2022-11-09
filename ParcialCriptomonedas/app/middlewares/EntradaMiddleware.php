<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class EntradaMiddleware{
    public function __invoke(Request $request,RequestHandler $handler) : Response
    {
        $response = $handler->handle($request);
        $existingContent= (string)$response->getBody();
        $response = new Response();
        $response->getBody()->write("Antes" . $existingContent);
        return $response;
    }
}
?>