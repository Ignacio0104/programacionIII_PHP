<?php
require_once './models/Criptomoneda.php';


class CriptomonedaController extends Criptomoneda 
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $precio = $parametros['precio'];
        $nombre = $parametros['nombre'];
        $URLImagen = $this->moverImagen();
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
        if(!$criptomoneda){
          $payload = json_encode(array("Error" => "No se encontró la criptomoneda solicitada"));
        }
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
        $datos = json_decode(file_get_contents("php://input"), true);
        $criptoModificada = new Criptomoneda();
        $criptoModificada->id=$datos["id"]; 
        $criptoModificada->nombre=$datos["nombre"]; 
        $criptoModificada->precio=$datos["precio"]; 
        $criptoModificada->URLImagen=$this->moverImagenBackup();
        $criptoModificada->nacionalidad=$datos["nacionalidad"]; 
        Criptomoneda::modificarCriptomoneda($criptoModificada);
        $payload = json_encode(array("mensaje" => "Criptomoneda modificada con exito"));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $criptoId = $datos['idCripto'];
        Criptomoneda::borrarCriptomoneda($criptoId);
        $payload = json_encode(array("mensaje" => "Criptomoneda borrada con éxito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    private function moverImagen()
    {
      $carpetaFotos = ".".DIRECTORY_SEPARATOR."fotosCripto".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
      if(!file_exists($carpetaFotos))
      {
          mkdir($carpetaFotos, 0777, true);
      }
      $nuevoNombre = $carpetaFotos.$_FILES["foto"]["name"];
      rename($_FILES["foto"]["tmp_name"], $nuevoNombre);

      return $nuevoNombre;
    }

    
    private function moverImagenBackup()
    {
      $carpetaFotos = ".".DIRECTORY_SEPARATOR."fotosCripto".DIRECTORY_SEPARATOR;
      $datos = json_decode(file_get_contents("php://input"), true);
      $nuevoNombre = $carpetaFotos.$datos["nombre"].".png";   
      $carpetaBackUp= ".".DIRECTORY_SEPARATOR."fotosCripto".DIRECTORY_SEPARATOR."Backup".DIRECTORY_SEPARATOR;
      if(file_exists($nuevoNombre))
      {
        if(!file_exists($carpetaBackUp))
        {
          mkdir($carpetaBackUp, 0777, true);
        }
        rename($nuevoNombre, $carpetaBackUp.$datos["nombre"].".png");

      }
      rename($datos["URLImagen"], $nuevoNombre);
      return $nuevoNombre;
    }


}
