<?php
require_once './models/Usuario.php';

class UsuarioController extends Usuario 
{
    public $tipoPerfiles = ["comprador","vendedor","proveedor"];
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuario = $parametros['mail'];
        $clave = $parametros['clave'];
        $perfilUsuario = $parametros["perfil_usuario"];

        // Creamos el usuario
        try{
          if(in_array($perfilUsuario,$this->tipoPerfiles))
          {
            $usr = new Usuario();
            $usr->mail = $usuario;
            $usr->clave = $clave;
            $usr->perfil_usuario= $perfilUsuario;
            $usr->crearUsuario();
    
            $payload = json_encode(array("mensaje" => "Usuario creado con exito"));
          }else{
            $payload = json_encode(array("Error!" => "Revisar el rol ingresado"));
          }


        }catch(\Throwable $ex)
        {
            $payload=json_encode(array("Error!" => $ex->getMessage()));
        }
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        //$parametros = $request->getParsedBody();
        $datos = json_decode(file_get_contents("php://input"), true);
        $usuarioAModificar = new Usuario();
        $usuarioAModificar->id=$datos["id"]; 
        $usuarioAModificar->usuario=$datos["usuario"]; 
        $usuarioAModificar->clave=$datos["clave"]; 
        if(array_key_exists("fechaBaja",$datos))
        {
          $usuarioAModificar->fechaBaja=$datos["fechaBaja"]; 
        }
        if(array_key_exists("perfil_usuario",$datos))
        {
          $usuarioAModificar->perfil_usuario=$datos["perfil_usuario"]; 
        }
        Usuario::modificarUsuario($usuarioAModificar);
        $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        //$parametros = $request->getParsedBody();

        $datos = json_decode(file_get_contents("php://input"), true);
        $usuarioId = $datos['id'];
        Usuario::borrarUsuario($usuarioId);

        $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
