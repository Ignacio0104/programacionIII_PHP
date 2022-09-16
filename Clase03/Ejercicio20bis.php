<?php
/*
Aplicación No 20 (Registro CSV)
Archivo: registro.php
método:POST
Recibe los datos del usuario(nombre, clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder hacer el alta,
guardando los datos en usuarios.csv.
retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario
*/

include_once "ClaseUsuario.php";

$usuarioCreado = new Usuario($_POST["usuario"],$_POST["clave"],$_POST["mail"]);

if(!is_null($usuarioCreado))
{
    if($usuarioCreado->GuardarUsuario($usuarioCreado))
    {
        echo "Se agregó correctamente";
    }else
    {
        echo "Hubo un error";
    }
}

?>