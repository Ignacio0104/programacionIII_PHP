<?php
require_once './models/Criptomoneda.php';

class CriptomonedaController extends Criptomoneda 
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $precio = $parametros['precio'];
        $nombre = $parametros['nombre'];
        $carpetaFotos = ".".DIRECTORY_SEPARATOR."fotosCripto".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
        if(!file_exists($carpetaFotos))
        {
            mkdir($carpetaFotos, 0777, true);
        }

        $nuevoNombre = $carpetaFotos.$_FILES["foto"]["name"];
        rename($_FILES["foto"]["tmp_name"], $nuevoNombre);
        $URLImagen = $nuevoNombre;
        $nacionalidad = $parametros['nacionalidad'];

        // Creamos el usuario
        $cripto = new Criptomoneda();
        $cripto->precio = $precio;
        $cripto->nombre = $nombre;
        $cripto->URLImagen= $URLImagen;
        $cripto->nacionalidad= $nacionalidad;
        $cripto->crearCriptomoneda();

        $payload = json_encode(array("mensaje" => "Criptomoneda creada con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerPorNacionalidad($request, $response, $args)
    {
        $pais = $_GET["nacionalidad"];
        $lista = Criptomoneda::obtenerCriptomonedaPorPais($pais);
        $payload = json_encode(array("listaCriptomonedasPais" => $lista));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerPorId($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $id = $args['id'];
        $criptomoneda = Criptomoneda::obtenerCriptomonedaPorId($id );
        $payload = json_encode($criptomoneda);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Criptomoneda::obtenerTodos();
        $payload = json_encode(array("listaCriptomonedas" => $lista));
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
