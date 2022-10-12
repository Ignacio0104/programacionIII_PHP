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

if(Operaciones::BuscarHelado($listaDeHelados,$_POST["sabor"],$_POST["tipo"]))
{
    echo "Si hay!";
}else{
    echo "No existe el sabor o el tipo";
}

?>