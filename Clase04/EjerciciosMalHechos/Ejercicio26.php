<?php
/*
Ignacio Smirlian

Aplicación No 26 (RealizarVenta)
Archivo: RealizarVenta.php
método:POST
Recibe los datos del producto(código de barra), del usuario (el id )y la cantidad de ítems
,por POST .
Verificar que el usuario y el producto exista y tenga stock.
crea un ID autoincremental(emulado, puede ser un random de 1 a 10.000).
carga los datos necesarios para guardar la venta en un nuevo renglón.
Retorna un :
“venta realizada”Se hizo una venta
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesaris en las clases
*/
include_once "ClaseProducto.php";
include_once "ClaseVenta.php";
include_once "ClaseUsuario.php";
session_start();

$listaDeProductos=array();
$listaDeVentas=array();
$listaDeUsuarios = array();

try
{
    $listaDeProductos = Producto::LeeUsuariosJSON($_FILES["archivoProductos"]["name"]);
    $listaDeVentas =  Venta::LeerVentasJSON($_FILES["archivoVentas"]["name"]);
    $listaDeUsuarios = Usuario::LeeUsuariosListaJSON($_FILES["archivoUsuarios"]["name"]);

}catch(Exception $ex)
{
    echo "Hubo un error al cargar las listas de productos";
}

if(count($listaDeVentas)>0)
{
    foreach ($listaDeVentas as $producto)
    {
        $producto->MostrarInformacion($producto);
        echo "\n";
    }
}
echo "---------------------\n";

Venta::GuardarListaVentasJSON($listaDeVentas);
/*
echo "El stock actual es: \n";
if(count($listaDeProductos)>0)
{
    foreach ($listaDeProductos as $producto)
    {
        $producto->MostrarInformacion($producto);
        echo "\n";
    }
}
echo "---------------------\n";

$productoElegido = Producto::BuscarProductoPorId($listaDeProductos,$_POST["codigoProducto"]);
$nuevaVenta = new Venta($_POST["usuario"],$productoElegido,$_POST["cantidad"]);

$nuevaVenta->ConfirmarVenta($listaDeProductos,$listaDeUsuarios,$productoElegido,$_POST["usuario"]);

$nuevaVenta->MostrarInformacion($nuevaVenta);


array_push($listaDeVentas,$nuevaVenta);

try
{
    $nuevaVenta->GuardarListaVentasJSON($listaDeVentas);
}catch(Exception $ex)
{
    echo "Hubo un error al guardar la lista de ventas";
}

try
{
    Usuario::GuardarListaJSON($listaDeUsuarios);
}catch(Exception $ex)
{
    echo "Hubo un error al guardar la lista de usuarios";
}


try
{
    $listaDeProductos[0]->GuardarListaProductosJSON($listaDeProductos);
}catch(Exception $ex)
{
    echo "Hubo un error al guardar la lista de productos";
}
*/

?>