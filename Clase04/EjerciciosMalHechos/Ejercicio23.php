<?php
/*
Aplicación No 23 (Registro JSON)
Archivo: registro.php
método:POST
Recibe los datos del usuario(nombre, clave,mail )por POST ,
crea un ID autoincremental(emulado, puede ser un random de 1 a 10.000). crear un dato
con la fecha de registro , toma todos los datos y utilizar sus métodos para poder hacer
el alta,
guardando los datos en usuarios.json y subir la imagen al servidor en la carpeta
Usuario/Fotos/.
retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario.
*/

include_once "ClaseUsuario.php";
session_start();

$listaUsuarios = Usuario::LeeUsuariosJSON("usuarios.json");

$usuarioCreado = new Usuario($_POST["usuarioIngresado"],$_POST["claveIngresada"],$_POST["mailIngresado"]);

if(!is_null($usuarioCreado))
{
    if($usuarioCreado->GuardarUsuarioJSON($usuarioCreado))
    {
        //OBTENGO TODOS LOS NOMBRES DE LOS ARCHIVOS
        $nombre = $_FILES["imagen"]["name"];
     
        //INDICO CUALES SERAN LOS DESTINOS DE LOS ARCHIVOS SUBIDOS Y SUS TIPOS
        $destinos = array();
        $tiposArchivo = array();
        $destino = "Usuario/Fotos/" . $nombre;
        array_push($destinos, $destino);
        array_push($tiposArchivo, pathinfo($destino, PATHINFO_EXTENSION));
               
        $uploadOk = TRUE;
        $mensaje='';
        
        //VERIFICO QUE LOS ARCHIVOS NO EXISTAN
        foreach($destinos as $destino){
            if (file_exists($destino)) {
                $mensaje = "El archivo {$destino} ya existe. Verifique!!!";
                $uploadOk = FALSE;
                break;
            }
        }
               
        //OBTIENE EL TAMAÑO DE UNA IMAGEN, SI EL ARCHIVO NO ES UNA
        //IMAGEN, RETORNA FALSE
        $tmpName = $_FILES["imagen"]["tmp_name"];
        $i=0;

        $esImagen = getimagesize($tmpName);
    
        if($esImagen) {//NO ES UNA IMAGEN
        //SOLO PERMITO CIERTAS EXTENSIONES
            if($tiposArchivo[$i] != "jpg" && $tiposArchivo[$i] != "jpeg" && $tiposArchivo[$i] != "gif"
                && $tiposArchivo[$i] != "png" && $tiposArchivo[$i] != "JPG") {
                $mensaje =  "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
                $uploadOk = FALSE;
            }
        }
        
        $i++;
      
        //VERIFICO SI HUBO ALGUN ERROR, CHEQUEANDO $uploadOk
        if ($uploadOk === FALSE) {
        
            $mensaje =  "<br/>NO SE PUDIERON SUBIR LOS ARCHIVOS.";        
        } else {
            //MUEVO LOS ARCHIVOS DEL TEMPORAL AL DESTINO FINAL
            if (move_uploaded_file($tmpName, $destinos[0])) {
                $mensaje =  "<br/>El archivo ". basename( $tmpName). " ha sido subido exitosamente.";
            } else {
                $mensaje =  "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo ". basename( $tmpName).".";
            }
            
        }

        echo $mensaje;
    }else
    {
        echo "Hubo un error";
    }
}

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