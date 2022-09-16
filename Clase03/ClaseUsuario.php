<?php


class Usuario
{
    private string $nombre;
    private string $clave;
    private string $mail;


    public function __construct($nombre,$clave,$mail)
    {   
        $this->nombre = $nombre;
        $this->clave = $clave; 
        $this->mail = $mail;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function MostrarInformacion(Usuario $usuario)
    {
        echo "Usuario: $usuario->nombre | Clave: $usuario->clave | Mail: $usuario->mail \n ";
    }

    public function InformacionUsuario(Usuario $usuario)    
    {
        return "$usuario->nombre,$usuario->clave,$usuario->mail";
    }

    public function GuardarUsuario (Usuario $usuario)
    {
        $archivo = fopen("usuarios.csv","a");
        $confirmacion = false; 
        if(fwrite($archivo,$usuario->InformacionUsuario($usuario) . PHP_EOL)!=false)
        {
            $confirmacion = true;
        }
        fclose($archivo);
        return $confirmacion;
    }

    public static function LeeUsuarios($nombreArchivo)
    {
        $archivo = fopen($nombreArchivo,"r");
        $arrayAtributos = array();
        $arrayDeUsuarios = array();

       while(!feof($archivo))
        {
            $arrayAtributos=fgetcsv($archivo);
            if(!empty($arrayAtributos))
            {
                $usuarioAuxiliar = new Usuario($arrayAtributos[0],$arrayAtributos[1],$arrayAtributos[2]);
                    array_push($arrayDeUsuarios,$usuarioAuxiliar);
            }
        }
        return $arrayDeUsuarios;
    }

    public static function ComprobarLogin($listaDeUsuarios,$usuarioIngresado,$claveIngresada)
    {
        foreach ($listaDeUsuarios as $usuario)
        {
            if(strcmp($usuario->getNombre(),$usuarioIngresado)==0)
            {
                if(strcmp($usuario->getClave(),$claveIngresada)==0)
                {
                    echo "Usuario verificado";
                    return;
                }else
                {
                    echo "Error en los datos";
                    return;
                }
            }
        }
        echo "Usuario no registrado";
    }
}

?>