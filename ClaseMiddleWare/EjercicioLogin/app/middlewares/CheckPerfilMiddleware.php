<?php
use Dotenv\Loader\Resolver;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class CheckPerfilMiddleware{
    public function __invoke(Request $request,RequestHandler $handler) : Response
    {
       $header = $request->getHeaderLine(("Authorization"));
       $token = trim(explode("Bearer",$header)[1]);
       $response= new Response();
       try {
        $data = AutentificadorJWT::ObtenerData($token);
        if($data->perfil_usuario=="admin")
        {
          echo "El usuario es admin";
          $response= $handler->handle($request);
        }else{
          echo " El usuario no es admin. No puede realizar esta acción";
        }
       
      } catch (Exception $e) {
        $response->getBody()->write(json_encode(array('error - Token invalido' => $e->getMessage())));
        $response = $response->withStatus(401);
      }

      return $response
        ->withHeader('Content-Type', 'application/json');
    }
}
?>