<?php
/*
Aplicación No 25 ( AltaProducto)
Archivo: altaProducto.php
método:POST
Recibe los datos del producto(código de barra (6 cifras ),nombre ,tipo, stock, precio )por POST
,
crea un ID autoincremental(emulado, puede ser un random de 1 a 10.000). crear un
objeto y utilizar sus métodos para poder verificar si es un producto existente, si ya existe
el producto se le suma el stock , de lo contrario se agrega al documento en un nuevo
renglón
Retorna un :
“Ingresado” si es un producto nuevo
“Actualizado” si ya existía y se actualiza el stock.
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en la clase

*/
include_once "ClaseProducto.php";
session_start();

$listaDeProductos=array();

try
{
    $listaDeProductos = Producto::LeeUsuariosJSON($_FILES["archivo"]["name"]);
}catch(Exception $ex)
{
    echo "Hubo un error al cargar la lista de productos";
}

try
{
    $nuevoProducto = new Producto(Producto::ConseguirUltimoID($listaDeProductos)+1,$_POST["nombre"],$_POST["tipo"],$_POST["stock"],$_POST["precio"]);
}catch(Exception $ex)
{
    echo "No se pudo dar de alta el producto";
}


$productoEnLaLista = $nuevoProducto->BuscarProducto($listaDeProductos,$nuevoProducto);
if($productoEnLaLista!=null)
{
    echo "El producto ya está en la lista. Aumentamos su stock\n";
    $productoEnLaLista->setStock($nuevoProducto->getStock() + $productoEnLaLista->getStock());

}else
{
    echo "No está en la lista. Lo agregamos:\n";
    array_push($listaDeProductos,$nuevoProducto);
}

try
{
    $nuevoProducto->GuardarListaProductosJSON($listaDeProductos);
}catch(Exception $ex)
{
    echo "Hubo un error al guardar la lista de productos";
}


if(count($listaDeProductos)>0)
{
    foreach ($listaDeProductos as $producto)
    {
        $producto->MostrarInformacion($producto);
        echo "\n";
    }
}

?>