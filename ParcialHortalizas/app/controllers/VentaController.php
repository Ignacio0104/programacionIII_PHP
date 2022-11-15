<?php
require_once './models/Hortaliza.php';
require_once './models/VentaHortaliza.php';
require_once './models/Usuario.php';
require "./fpdf/fpdf.php";

class VentaController extends VentaHortaliza 
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $idCliente = $parametros['idCliente'];
        $idHortaliza = $parametros['idHortaliza'];
        $cantidad = $parametros['cantidad'];

        try{
        $hortalizarAuxiliar=Hortaliza::obtenerHortalizaPorId($idHortaliza);
        $clienteAuxiliar = Usuario::obtenerUsuarioPorId($idCliente);
          if($hortalizarAuxiliar!= null && $clienteAuxiliar != null && $clienteAuxiliar->perfil_usuario == "comprador")
          {
            $venta = new VentaHortaliza();
            $venta->idHortaliza = $idHortaliza;
            $venta->cantidad = $cantidad;
            $venta->tipoUnidad= $hortalizarAuxiliar->tipoUnidad;
            $venta->idCliente = $idCliente;
            $venta->URLImagen = $this->moverImagen($clienteAuxiliar->mail,$hortalizarAuxiliar->nombre);
            $venta->crearVenta();
            $payload = json_encode(array("mensaje" => "Venta creada con exito"));
          }else{
            $payload = json_encode(array("Error!" => "Revisar id hortaliza y id cliente"));
          }

        }catch(\Throwable $ex)
        {
            $payload=json_encode(array("Error!" => $ex->getMessage()));
        }
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerVentasConParametros($request, $response, $args)
    {
        $clima = $_GET["clima"];
        $inicio = $_GET["fechaInicio"];
        $fin = $_GET["fechaFinal"];      
        $listaDeVentas= VentaHortaliza::obtenerVentaParametros($clima,$inicio,$fin);
        $payload = json_encode(array("listaDeVentas" => $listaDeVentas));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerVentasPorNombre($request, $response, $args)
    {
        $hortaliza = $_GET["hortaliza"];    
        $listaDeUsuarios= VentaHortaliza::obtenerVentaPorNombre($hortaliza);
        $payload = json_encode(array("listaDeUsuarios" => $listaDeUsuarios));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ImprimirPDF($request, $response, $args)
    {
        $lista = VentaHortaliza::obtenerTodos();
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(40,10,"Lista de ventas: ");
        $pdf->Ln();
        for ($i=0; $i <count($lista)-1 ; $i++) { 
          $pdf->Cell(40,10,$lista[$i]);
          $pdf->Ln();       
        }
        $pdf->Output('F', './archivos/' . "reporteVentasHortalizas" .'.pdf', 'I');
        $payload = json_encode(array("PDF Guardado" => "El PDF se guardó con éxito"));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }



    private function moverImagen($cliente,$hortaliza)
    {
      $carpetaFotos = ".".DIRECTORY_SEPARATOR."FotosHortalizas".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
      if(!file_exists($carpetaFotos))
      {
          mkdir($carpetaFotos, 0777, true);
      }
      $fecha = date("Y-m-d");
      $nuevoNombre = $carpetaFotos.$hortaliza.$cliente.$fecha.".png";
      rename($_FILES["foto"]["tmp_name"], $nuevoNombre);

      return $nuevoNombre;
    }

}
