<?php

include_once "Venta.php";
include_once "Helado.php";
include_once "ManejoJSON.php";
include_once "Operaciones.php";
include_once "Descuento.php";

$listaDeVentas = array();
$listaDeDevoluciones = array();
$listaDeCupones = array();

$listaDeJSON = ManejoJSON::LeerListaJSON("Ventas.json");
if($listaDeJSON!=null &&count($listaDeJSON)>0)
{
    foreach ($listaDeJSON as $ventaJson)
    {
        $ventaAuxiliar = new Venta ($ventaJson["id"],$ventaJson["mailUsuario"],
        $ventaJson["sabor"],$ventaJson["tipo"],$ventaJson["cantidad"],$ventaJson["numeroDePedido"],
    $ventaJson["fechaDePedido"]);
        array_push($listaDeVentas,$ventaAuxiliar);
    }
}

$listaDeJSON = ManejoJSON::LeerListaJSON("cupones.json");
if($listaDeJSON!=null &&count($listaDeJSON)>0)
{
    foreach ($listaDeJSON as $cuponesJson)
    {
        $cuponAuxiliar = new Descuento ($cuponesJson["id"],$cuponesJson["idPedido"], $cuponesJson["porcentajeDescuento"],$cuponesJson["usado"]);
        array_push($listaDeCupones,$cuponAuxiliar);
    }
}


$numeroDePedido = $_POST["numeroPedido"];
$causaDevolucion = $_POST["causa"];
$ventaBuscada = Operaciones::BuscarVenta($listaDeVentas,$numeroDePedido);

if($ventaBuscada !=null)
{
    array_push($listaDeDevoluciones,$ventaBuscada);
    $cuponDescuento = new Descuento(Operaciones::ConseguirIDMaximo($listaDeCupones,100)+1,$numeroDePedido,10,false);
    echo "Cupon generado";
    array_push($listaDeCupones,$cuponDescuento);
}


ManejoJSON::GuardarListaJSON($listaDeVentas,"Ventas.json");
ManejoJSON::GuardarListaJSON($listaDeCupones,"cupones.json");
ManejoJSON::GuardarListaJSON($listaDeDevoluciones,"devoluciones.json");


?>