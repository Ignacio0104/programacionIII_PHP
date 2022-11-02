<?php
use Dotenv\Loader\Resolver;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class CheckDataMiddleWare{

    private $typos = ["administrador","empleado","cliente"];
    public function __invoke(Request $request,RequestHandler $handler) : Response
    {
        $response = new Response();
        $parametros = $request->getParsedBody();
        $usuario = $parametros["usuario"];
        $clave = $parametros["clave"];
        $perfil = $parametros["perfil"];
        try{
            if(!empty($usuario) && !empty($clave) && !empty($perfil)){
                if(in_array($perfil, $this->typos))
                {
                    if($perfil == "administrador")
                    {
                        $response= $handler->handle($request);
                        $response->getBody()->write("\nEsto es despues del middleware"); 
                    }else{
                        $response->getBody()->write(json_encode(array("Error desde el Middleware"=>"No tiene acceso con ese perfil")));
                        $response = $response->withStatus(401);
                    }
                }else{
                    $response->getBody()->write(json_encode(array("Error desde el Middleware"=>"No tiene acceso")));
                    $response = $response->withStatus(401);
                }
            }else{
                $response->getBody()->write(json_encode(array("Error desde el Middleware"=>"Faltan datos clave")));
                $response = $response->withStatus(401);
            }
            
        }catch (\Throwable $th){
            echo $th->getMessage();
        }

        return $response->withHeader("Content-type","application/json");
        $response=$handler->handle($request);
    }
}
?>