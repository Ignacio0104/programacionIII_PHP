<?php

/*
Aplicación No 24 ( Listado JSON y array de usuarios)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,vehículos,...etc),por ahora solo tenemos
usuarios).
En el caso de usuarios carga los datos del archivo usuarios.json.
se deben cargar los datos en un array de usuarios.
Retorna los datos que contiene ese array en una lista
<ul>
<li>apellido, nombre,foto</li>
<li>apellido, nombre,foto</li>
</ul>
Hacer los métodos necesarios en la clase usuario
*/

include_once "ClaseUsuario.php";
session_start();

$listaUsuarios = Usuario::LeeUsuariosJSON($_GET['archivo']);

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