<?php
require_once './models/Hortaliza.php';

class HortalizaController extends Hortaliza 
{
    public $tipoClima = ["seco","humedo","todos"];
    public $tipoUnidades = ["kilo","bolsa","paquete"];
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $precio = $parametros['precio'];
        $nombre = $parametros['nombre'];
        $URLImagen = $this->moverImagen();
        $clima = $parametros["clima"];
        $tipoUnidad = $parametros["tipoUnidad"];
        // Creamos el usuario
        try{
          if(in_array($clima,$this->tipoClima) && in_array($tipoUnidad,$this->tipoUnidades))
          {
            $hortaliza = new Hortaliza();
            $hortaliza->precio = $precio;
            $hortaliza->nombre = $nombre;
            $hortaliza->clima= $clima;
            $hortaliza->tipoUnidad= $tipoUnidad;
            $hortaliza->URLImagen= $URLImagen;
            $hortaliza->crearHortaliza();
    
            $payload = json_encode(array("mensaje" => "Hortaliza creada con exito"));
          }else{
            $payload = json_encode(array("Error!" => "Revisar el clima y/o el tipo de unidad"));
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
        $lista = Hortaliza::obtenerTodos();
        $payload = json_encode(array("listaDeHortalizas" => $lista));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerPorClima($request, $response, $args)
    {
        $clima = $_GET["clima"];
        $lista = Hortaliza::obtenerHortalizaPorClima($clima);
        $payload = json_encode(array("listaHortalizasPorClima" => $lista));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerPorId($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $id = $_GET['id'];
        $hortaliza = Hortaliza::obtenerHortalizaPorId($id );
        $payload = json_encode($hortaliza);
        if(!$hortaliza){
          $payload = json_encode(array("Error" => "No se encontró la hortaliza solicitada"));
        }
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $idHortaliza = $datos['id'];
        Hortaliza::borrarHortaliza($idHortaliza);
        $payload = json_encode(array("mensaje" => "Hortaliza borrada con éxito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $hortaliza = new Hortaliza();
        $hortaliza->id=$datos["id"]; 
        $hortaliza->nombre=$datos["nombre"]; 
        $hortaliza->precio=$datos["precio"]; 
        $hortaliza->URLImagen=$this->moverImagenBackup();
        $hortaliza->clima=$datos["clima"]; 
        $hortaliza->tipoUnidad=$datos["tipoUnidad"]; 
        Hortaliza::modificarHortaliza($hortaliza);
        $payload = json_encode(array("mensaje" => "Hortaliza modificada con exito"));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    private function moverImagen()
    {
      $carpetaFotos = ".".DIRECTORY_SEPARATOR."FotosHortalizas".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
      if(!file_exists($carpetaFotos))
      {
          mkdir($carpetaFotos, 0777, true);
      }
      $nuevoNombre = $carpetaFotos.$_FILES["URLImagen"]["name"];
      rename($_FILES["URLImagen"]["tmp_name"], $nuevoNombre);

      return $nuevoNombre;
    }

    private function moverImagenBackup()
    {
      $carpetaFotos = ".".DIRECTORY_SEPARATOR."fotosHortalizas".DIRECTORY_SEPARATOR;
      $datos = json_decode(file_get_contents("php://input"), true);
      $nuevoNombre = $carpetaFotos.str_replace(' ', '', $datos["nombre"]).".png";   
      $carpetaBackUp= ".".DIRECTORY_SEPARATOR."fotosHortalizas".DIRECTORY_SEPARATOR."Backup".DIRECTORY_SEPARATOR;
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
