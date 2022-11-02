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
        $data = json_encode(array('datos' => AutentificadorJWT::ObtenerData($token)));
        echo $data;
        if(strcmp($data["perfil"],"adminitrador")==0)
        {
          echo "El usuario es admin";
        }else{
          echo "El usuario no es admin";
        }
        $response= $handler->handle($request);
       
      } catch (Exception $e) {
        $response->getBody()->write(json_encode(array('error - Token invalido' => $e->getMessage())));
        $response = $response->withStatus(401);
      }

      return $response
        ->withHeader('Content-Type', 'application/json');
    }
}
?>