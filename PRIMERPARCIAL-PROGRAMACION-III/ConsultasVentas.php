<?php
include_once "Venta.php";
include_once "Helado.php";
include_once "ManejoJSON.php";
include_once "Operaciones.php";

$listaDeHelados=array();
$listaDeVentas = array();
$listaDeVentasEntreFechas = array();
$listaDeVentasPorUsuario=array();
$listaDeVentasPorSabor =array();
$fechaIndividual = new DateTime($_GET["fecha"]);
$fechaInicio=new DateTime($_GET["inicio"]);
$fechaFinal = new DateTime($_GET["final"]);
$cantidadHeladosVendidos = 0;

$listaDeJSON = ManejoJSON::LeerListaJSON("heladeria.json");

if($listaDeJSON!=null &&count($listaDeJSON)>0)
{
    foreach ($listaDeJSON as $heladoJson) {
        $tipo = 0;
        if(strcmp($heladoJson["tipo"],"crema")==0)
        {
            $tipo = 1;
        }
        $heladoAuxiliar = new Helado($heladoJson["id"],$heladoJson["sabor"],
        $heladoJson["precio"],$tipo,$heladoJson["stock"]);
        array_push($listaDeHelados,$heladoAuxiliar);
    }
}
$listaDeJSON = ManejoJSON::LeerListaJSON("Ventas.json");
if($listaDeJSON!=null &&count($listaDeJSON)>0)
{
    foreach ($listaDeJSON as $ventaJson)
    {
        $ventaAuxiliar = new Venta ($ventaJson["id"],$ventaJson["mailUsuario"],
        $ventaJson["sabor"],$ventaJson["tipo"],$ventaJson["cantidad"],$ventaJson["numeroDePedido"],
    $ventaJson["fechaDePedido"]);

        $fechaAuxiliar = new DateTime($ventaAuxiliar->fechaDePedido);

        if($fechaIndividual==null)
        {
            $fechaIndividual = new DateTime("10/10/2022");
        }
        if($fechaIndividual == $fechaAuxiliar)
        {
            $cantidadHeladosVendidos+=$ventaAuxiliar->cantidad;
        }

        if(strcmp($ventaAuxiliar->mailUsuario,$_GET["usuarioFiltro"])==0)
        {
            array_push($listaDeVentasPorUsuario,$ventaAuxiliar);
        }

        if($fechaInicio < $fechaAuxiliar && $fechaAuxiliar < $fechaFinal)
        {
            array_push($listaDeVentasEntreFechas,$ventaAuxiliar);
        }

        if(strcmp($ventaAuxiliar->sabor,$_GET["saborFiltro"])==0)
        {
            array_push($listaDeVentasPorSabor,$ventaAuxiliar);
        }

        array_push($listaDeVentas,$ventaAuxiliar);
    }
}

echo "Se vendieron $cantidadHeladosVendidos helados\n";

$usuarioFiltro = $_GET["usuarioFiltro"] ;

echo "El usuario $usuarioFiltro realizó las siguientes compras:";

foreach ($listaDeVentasPorUsuario as $item) {
    $item->Mostrar();
    echo "\n";
 }

echo "Ventas por fecha:\n";

usort($listaDeVentasEntreFechas,"Operaciones::CompararNombres");
foreach ($listaDeVentasEntreFechas as $item) {
   $item->Mostrar();
   echo "\n";
}

 echo "Ventas por sabor: \n";
 foreach ($listaDeVentasPorSabor as $item) {
    $item->Mostrar();
    echo "\n";
 }

?>