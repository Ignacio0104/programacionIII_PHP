<?php
/*
Aplicación No 28 ( Listado BD)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,ventas)
cada objeto o clase tendrán los métodos para responder a la petición
devolviendo un listado <ul> o tabla de html <table>
*/

include_once "ClaseUsuario.php";
include_once "AccesoDatos.php";
session_start();

$lista;

switch($_GET['archivo'])
{
    case "usuarios":
        $lista=Usuario::TraerListaUsuarios();
        break;
    case "productos":
        echo "Traer info productos";
        break;
    case "ventas":
        echo "Traer info de ventas";
        break;
}

foreach ($lista as $usuario)
{
    $nombre = $usuario->getNombre();
    $clave = $usuario->getClave();
    $mail = $usuario->getMail();
    echo
    "
    <ul>
        <li>$nombre</li>
        <li>$clave</li>
        <li>$mail</li>
    </ul>
    ";
}

?>