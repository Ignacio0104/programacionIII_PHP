<?php


class Usuario
{
    private string $nombre;
    private string $clave;
    private string $mail;
    private int $id;
    private DateTime $fechaRegistro;
    private static int $primerId;
    private static $primeraVez = false;

    private static function inicializar()
    {
        self::$primeraVez=true;
        self::$primerId = random_int(1,10000);
    }
    public function __construct($nombre,$clave,$mail)
    {   
        if(!self::$primeraVez)
        {
            self::inicializar();
        }
        $this->nombre = $nombre;
        $this->clave = $clave; 
        $this->mail = $mail;
        $this->id =  self::$primerId;
        $this->fechaRegistro = new DateTime(date('d-m-y h:i:s'));
        self::$primerId++;
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

    public function getId()
    {
        return $this->id;
    }

    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }
    public function MostrarInformacion(Usuario $usuario)
    {
        echo "Usuario: $usuario->nombre | Clave: $usuario->clave | Mail: $usuario->mail \n ";
        echo "ID: $usuario->id | Fecha de registro: ";
        echo $usuario->fechaRegistro->format('d-m-y h:i:s');
    }

    public function InformacionUsuario(Usuario $usuario)    
    {
        $texto = "$usuario->nombre,$usuario->clave,$usuario->mail,$usuario->id,";
        $texto.=$usuario->fechaRegistro->format('d-m-y h:i:s');
        return $texto;
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

    
    public function GuardarUsuarioJSON (Usuario $usuario)
    {
        $archivo = fopen("usuarios.json","a");
        $confirmacion = false; 
        if(fwrite($archivo,json_encode($usuario->InformacionUsuario($usuario)). PHP_EOL)!=false)
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

    public static function LeeUsuariosJSON($nombreArchivo)
    {
        $archivo = fopen($nombreArchivo,"r");
        $arrayAtributos = array();
        $arrayDeUsuarios = array();

       while(!feof($archivo))
        {
            $arrayAtributos=fgetcsv($archivo);           
            if(!empty($arrayAtributos))
            {
                $arraySeparado = explode(",",$arrayAtributos[0]);
                $usuarioAuxiliar = new Usuario($arraySeparado[0],$arraySeparado[1],$arraySeparado[2]);
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