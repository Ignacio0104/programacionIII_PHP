<?php
require_once './models/Venta.php';

class VentaController extends Venta 
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $idCripto= $parametros['idCripto'];
        $mailUsuario= $parametros['mailUsuario'];
        $cantidad= $parametros['cantidad'];
        $carpetaFotos = ".".DIRECTORY_SEPARATOR."FotsCriptoVenta".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
        if(!file_exists($carpetaFotos))
        {
            mkdir($carpetaFotos, 0777, true);
        }
        $nuevoNombre = $carpetaFotos.$_FILES["foto"]["name"];
        rename($_FILES["foto"]["tmp_name"], $nuevoNombre);
        $URLImagen = $nuevoNombre;

        // Creamos el usuario
        $venta = new Venta();
        $venta->idCripto = $idCripto;
        $venta->mailUsuario = $mailUsuario;
        $venta->cantidad= $cantidad;    
        $venta->URLImagen= $URLImagen;
        $venta->crearVenta();

        $payload = json_encode(array("mensaje" => "Venta creada con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerVentasConParametros($request, $response, $args)
    {
        $pais = $_GET["pais"];
        $inicio = $_GET["fechaInicio"];
        $fin = $_GET["fechaFinal"];      
        $listaDeVentas= Venta::obtenerVentaParametros($pais,$inicio,$fin);
        $payload = json_encode(array("listaDeVentas" => $listaDeVentas));
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


}
