<?php
include_once "Helado.php";
include_once "ManejoJSON.php";
include_once "Operaciones.php";

$listaDeJSON = ManejoJSON::LeerListaJSON("heladeria.json");
$listaDeHelados=array();

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

if(Operaciones::BuscarHelado($listaDeHelados,$_POST["sabor"],$_POST["tipo"])==null)
{
    echo "El helado no existe y lo vamos a crear\n";
    $heladoNuevo = CrearHelado($listaDeHelados,$_POST["sabor"],$_POST["precio"],$_POST["tipo"],$_POST["cantidad"]);
    if($heladoNuevo==null){
        echo "No se pudo cargar el helado, verificar los datos\n";
    }else{
        array_push($listaDeHelados,$heladoNuevo);
    }        
}else{
    echo "El helado existe, actualizamos los datos\n";
    ActualizarHelado(Operaciones::BuscarHelado($listaDeHelados,$_POST["sabor"],$_POST["tipo"]),$_POST["precio"],$_POST["cantidad"]);
}
foreach ($listaDeHelados as $helado) {
    $helado->Mostrar();
    echo "\n";
}

/*--------------------------------------------------------*/
ManejoJSON::GuardarListaJSON($listaDeHelados,"heladeria.json");

function CrearHelado($listaDeHelados,$sabor,$precio,$tipo,$cantidad)
{
    if($tipo>=0 && $tipo<3)
    {    
        $heladoAuxiliar = new Helado(Operaciones::ConseguirIDMaximo($listaDeHelados,1000)+1,$sabor,$precio,$tipo,$cantidad);
        if($heladoAuxiliar->GuardarImagen())
        {
            return $heladoAuxiliar;
        }
    }
   return null;
}


function ActualizarHelado ($helado,$precio,$stock)
{
    $helado->precio = $precio;
    $helado->stock = $helado->stock + $stock;
}



?>