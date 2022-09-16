<?php
/*
Ignacio Smirlian 

Aplicación No 21 ( Listado CSV y array de usuarios)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,vehículos,...etc),por ahora solo tenemos
usuarios).
En el caso de usuarios carga los datos del archivo usuarios.csv.
se deben cargar los datos en un array de usuarios.
Retorna los datos que contiene ese array en una lista
*/
include_once "ClaseUsuario.php";

$listaUsuarios = Usuario::LeeUsuarios($_FILES['usuarios']['name']); //Esta mal, funciona con POST. Ver ejercicio 25

foreach ($listaUsuarios as $usuario)
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