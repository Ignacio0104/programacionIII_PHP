<?php
/*
Aplicación No 29( Login con bd)
Archivo: Login.php
método:POST
Recibe los datos del usuario(clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder verificar si es un usuario registrado en la
base de datos,
Retorna un :
“Verificado” si el usuario existe y coincide la clave también.
“Error en los datos” si esta mal la clave.
“Usuario no registrado si no coincide el mail“
Hacer los métodos necesarios en la clase usuario.

*/


include_once "ClaseUsuario.php";
include_once "AccesoDatos.php";
$listaDeUsuarios = Usuario::TraerListaUsuarios();


$usuarioAuxiliar = new Usuario(Usuario::BuscarIdMaximo($listaDeUsuarios)+1, $_POST["nombre"],$_POST["apellido"],$_POST["clave"],$_POST["mailIngresado"],$_POST["localidad"]);

if(Usuario::ComprobarLogin($listaDeUsuarios,$usuarioAuxiliar->getMail(),$usuarioAuxiliar->getClave()))
{
    $usuarioAuxiliar->InsertarUsuario();
}


?>