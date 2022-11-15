<?php
require_once './models/AutentificadorJWT.php';
require_once './interfaces/IApiUsable.php';

class AutentificadorController extends AutentificadorJWT
{
    public function CrearTokenLogin ($request, $response,$args)
    {
        $parametros = $request->getParsedBody();
        $usuarioBaseDeDatos=Usuario::obtenerUsuario($parametros["mail"]);
        if($usuarioBaseDeDatos !=null)
        {
            if(password_verify($parametros["clave"],$usuarioBaseDeDatos->clave))
            {
                $datos = array('usuario' => $usuarioBaseDeDatos->mail, 'clave' => $usuarioBaseDeDatos->clave
                ,"perfil_usuario"=> $usuarioBaseDeDatos->perfil_usuario);
                $token = AutentificadorJWT::CrearToken($datos);
                $payload = json_encode(array('jwt' => $token));
                $response->getBody()->write($payload);

            }else{
                $response->getBody()->write("Error en los datos ingresados");
            }
        }else{
            $response->getBody()->write("El usuario no existe");
        }

        return $response
        ->withHeader('Content-Type', 'application/json');
    }
}
?>


