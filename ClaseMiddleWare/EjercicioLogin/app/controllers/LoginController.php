<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

class LoginController extends Usuario
{
    public function VerificarClave ($request, $response,$args)
    {
        //$datos = json_decode(file_get_contents("php://input"), true);
        //$datos= $request->getParsedBody(); 
        $parametros = $request->getParsedBody();
        $usuarioBaseDeDatos=Usuario::obtenerUsuario($parametros["usuario"]);

       /* if(password_verify($parametros["clave"],$usuarioBaseDeDatos->clave))
        {
            $payload = json_encode(array("mensaje" => "Usuario logueado"));
        }else{
            $payload = json_encode(array("mensaje" => "Error!"));
        }*/
        
       if(password_verify($parametros["clave"],$usuarioBaseDeDatos->clave))
        {
            $payload = "Retorno desde el controller $usuarioBaseDeDatos" ;
        }else{
            $payload = "Retorno desde el controller Error";
        }
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
?>