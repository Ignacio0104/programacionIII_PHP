<?php
include_once "Venta.php";
include_once "PizzaCarga.php";

function CrearVenta($listaDeVentas,$listaDePizza,$mailUsuario,$sabor,$tipo,$cantidad, $numeroDePedido)
{
    $pizzaPedida = BuscarPizza($listaDePizza,$sabor,$tipo);
    if($pizzaPedida != null)
    {
        $ventaNueva = new Venta(ConseguirUltimoIDVenta($listaDeVentas)+1,$mailUsuario,$sabor,$tipo,$cantidad,$numeroDePedido);
        return $ventaNueva;
    }
    return null;
}

function GuardarListaVentasJSON ($arrayVentas)
{
    $archivo = fopen("Ventas.json","w");
    $confirmacion = false; 
    
    if(fwrite($archivo,json_encode($arrayVentas,JSON_PRETTY_PRINT). PHP_EOL)!=false)
    {
        $confirmacion = true;
    }  
    fclose($archivo);
    return $confirmacion;
}


function LeerVentasListaJSON($nombreArchivo)
{
    if(file_exists($nombreArchivo)){
        $archivo = fopen($nombreArchivo,"r");
        $arrayAtributos = array();
        $arrayDeVentas = array();
    
        if(filesize($nombreArchivo)>0){
            $json = fread($archivo,filesize($nombreArchivo));
            $arrayAtributos=json_decode($json,true);
                
            if(!empty($arrayAtributos))
            {
                foreach ($arrayAtributos as $ventaJson)
                {
                    $ventaAuxiliar = new Venta ($ventaJson["id"],$ventaJson["mailUsuario"],
                    $ventaJson["sabor"],$ventaJson["tipo"],$ventaJson["cantidad"],$ventaJson["numeroDePedido"],
                $ventaJson["fechaDePedido"]);
                    array_push($arrayDeVentas,$ventaAuxiliar);
                }
            }
            fclose($archivo);  
            return $arrayDeVentas;  
        }
    }else{
        echo "El archivo ventas no existe\n";
    }
}

function ConseguirUltimoIDVenta($listaDeVentas)
{
    $idMaxima = 0;
    if($listaDeVentas != null && count($listaDeVentas)>0)
    {
        foreach ($listaDeVentas as $venta)
        {
            if($venta->id>$idMaxima)
            {
                $idMaxima =$venta->id;
            }
        }
    }
    return $idMaxima;
}

?>