<?php

include_once "ClaseUsuario.php";
include_once "AccesoDatos.php";

$listaUsuarios = Usuario::TraerListaUsuarios();

try
{
    $usuarioCreado = new Usuario(Usuario::BuscarIdMaximo($listaUsuarios)+1,$_POST["nombre"],$_POST["apellido"],$_POST["clave"],$_POST["mailIngresado"],$_POST["localidad"]);
    array_push($listaUsuarios,$usuarioCreado);
    echo "Usuario agregado con éxito\n";
}catch(Exception $ex){
    echo "No se pudo agregar el usuario\n";
}

$usuarioCreado->InsertarUsuario();

$listaUsuarios = Usuario::TraerListaUsuarios();

foreach ($listaUsuarios	 as $usuario) {
    echo $usuario->MostrarInformacion($usuario);
    echo "\n";
}

?>