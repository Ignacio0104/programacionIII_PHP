<?php
include_once "Venta.php";
include_once "Helado.php";
include_once "ManejoJSON.php";
include_once "Operaciones.php";
include_once "Descuento.php";

$listaDeJSON = ManejoJSON::LeerListaJSON("heladeria.json");
$listaDeHelados=array();
$listaDeVentas = array();
$listadDeCupones = array();

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
        array_push($listaDeVentas,$ventaAuxiliar);
    }
}

$listaDeJSON = ManejoJSON::LeerListaJSON("cupones.json");
if($listaDeJSON!=null &&count($listaDeJSON)>0)
{
    foreach ($listaDeJSON as $cuponJson)
    {
        $cuponAuxiliar = new Descuento ($cuponJson["id"],$cuponJson["idPedido"],
        $cuponJson["porcentajeDescuento"],$cuponJson["usado"]);
        array_push($listadDeCupones,$cuponAuxiliar);
    }
}

$ventaCreada = CrearVenta($listaDeVentas,$listaDeHelados,$_POST["mailUsuario"],$_POST["sabor"],
$_POST["tipo"],$_POST["cantidad"],$_POST["numeroPedido"]);
if($ventaCreada!=null){
    if($ventaCreada->GuardarImagen())
    {
        if($listaDeVentas == null)
        {
            $listaDeVentas= array();
        }
        $heladoElegido = Operaciones::BuscarHelado($listaDeHelados,$_POST["sabor"],$_POST["tipo"]);
        if($heladoElegido !=null)
        {
            $cuponUtilizado = Operaciones::BuscarCupon($listadDeCupones,$_POST["cuponDescuento"]);
            if($cuponUtilizado !=null &&$cuponUtilizado->usado == false)
            {
                $cuponUtilizado->usado = true;
                echo "Cupon utilizado";
            }
                $stockActualizado = $heladoElegido->stock - $_POST["cantidad"];
                if($stockActualizado>=0)
                {
                    $heladoElegido->stock = $heladoElegido->stock - $_POST["cantidad"];
                    echo "Venta creada con éxito";
                    array_push($listaDeVentas,$ventaCreada);
                    ManejoJSON::GuardarListaJSON($listaDeVentas,"Ventas.json");
                    ManejoJSON::GuardarListaJSON($listaDeHelados,"heladeria.json");
                    ManejoJSON::GuardarListaJSON($listadDeCupones,"cupones.json");
                }else{
                    echo "No hay más disponibilidad";
                }
            }
            

    }
  }else{
    echo "No se pudo crear la venta. Revisar los datos\n";
}

function CrearVenta($listaDeVentas,$listaDeHelados,$mailUsuario,$sabor,$tipo,$cantidad, $numeroDePedido)
{
    $heladoPedido =Operaciones::BuscarHelado($listaDeHelados,$sabor,$tipo);
    if($heladoPedido != null)
    {
        $ventaNueva = new Venta(Operaciones::ConseguirIDMaximo($listaDeVentas,0)+1,$mailUsuario,$sabor,$tipo,$cantidad,$numeroDePedido);
        return $ventaNueva;
    }
    return null;
}

?>