<?php


class Usuario
{
    public string $nombre;
    public string $clave;
    public string $mail;
    public int $id;
    public DateTime $fechaRegistro;
    public static int $primerId;
    public static $primeraVez = false;

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

    public function setId($id)
    {
        $this->id=$id;
    }

    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro=$fechaRegistro;
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


    public static function GuardarListaJSON ($usuarios)
    {
        $archivo = fopen("usuarios.json","w");
        $confirmacion = false; 
        
        if(fwrite($archivo,json_encode($usuarios,JSON_PRETTY_PRINT). PHP_EOL)!=false)
        {
            $confirmacion = true;
        }  
        fclose($archivo);
        return $confirmacion;
    }

    public static function LeeUsuariosListaJSON($nombreArchivo)
    {
        $archivo = fopen($nombreArchivo,"r");
        $arrayAtributos = array();
        $arrayDeUsuarios = array();

        $json = fread($archivo,filesize($nombreArchivo));
        $arrayAtributos=json_decode($json,true);
          
        if(!empty($arrayAtributos))
        {
            foreach ($arrayAtributos as $usuarioJson)
            {
                $usuarioAuxiliar = new Usuario($usuarioJson["nombre"],$usuarioJson["clave"],$usuarioJson["mail"]);
                $usuarioAuxiliar->setId($usuarioJson["id"]);  
                $usuarioAuxiliar->setFechaRegistro(new DateTime($usuarioJson["fechaRegistro"]["date"])); 
                array_push($arrayDeUsuarios,$usuarioAuxiliar);
            }
        }

        fclose($archivo);  
        return $arrayDeUsuarios;
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

    public static function BuscarUsuario($listaDeUsuarios,$usuarioIngresado)
    {
        foreach ($listaDeUsuarios as $usuario)
        {
            if(strcmp($usuario->getNombre(),$usuarioIngresado)==0)
            {
                return $usuario;
            }
        }
        return null;
    }
}


?>


