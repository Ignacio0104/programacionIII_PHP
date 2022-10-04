<?php

class Usuario
{
    public int $id;
    public string $nombre;
    public string $apellido;
    public string $clave;
    public string $mail;
    public string $localidad;
    public DateTime $fechaRegistro;
    public string $fechaRegistroString;
    public static int $primerId;
    public static $primeraVez = false;

    private static function inicializar()
    {
        self::$primeraVez=true;
        self::$primerId = random_int(1,10000);
    }
    public function __construct($id="",$nombre="",$apellido="",$clave="",$mail="",$localidad="",$fechaRegistroString="")
    {   
        if(!self::$primeraVez)
        {
            self::inicializar();
        }
        if($nombre !="")
        {
            $this->nombre = $nombre;
            $this->apellido=$apellido;
            $this->clave = $clave; 
            $this->mail = $mail;
            $this->localidad=$localidad;
            $this->id =  $id;
            $this->fechaRegistro = new DateTime(date('d-m-y h:i:s'));
            $this->fechaRegistroString =  $this->fechaRegistro->format('d-m-y');
            self::$primerId++;
        }

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
        echo "Usuario: $usuario->nombre | Apellido: $usuario->apellido | Clave: $usuario->clave | Mail: $usuario->mail \n ";
        echo "ID: $usuario->id | Fecha de registro: $usuario->fechaRegistroString\n";
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

        public static function BuscarIdMaximo($listaDeUsuarios)
    {
        $idMaxima=0;
        foreach ($listaDeUsuarios as $usuario)
        {
            if($usuario->getId()>$idMaxima)
            {
                $idMaxima=$usuario->getId();
            }
        }
        return $idMaxima;
    }


    public function BorrarUsuario()
    {
           $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
           $consulta =$objetoAccesoDato->RetornarConsulta("
               delete 
               from usuario				
               WHERE id=:id");	
               $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
               $consulta->execute();
               return $consulta->rowCount();
    }

   public function ModificarUsuario()
    {
           $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
           $consulta =$objetoAccesoDato->RetornarConsulta("
               update usuario 
               set id='$this->id',
               nombre='$this->nombre',
               apellido='$this->apellido',
               clave='$this->clave',
               mail='$this->mail',
               localidad='$this->localidad',
               fecha_de_registro='$this->fechaRegistro',
               WHERE id='$this->id'");
           return $consulta->execute();
    }

    //Sin implementar
    public function ModificarCdParametros()
    {
           $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
           $consulta =$objetoAccesoDato->RetornarConsulta("
               update cds 
               set titel=:titulo,
               interpret=:cantante,
               jahr=:anio
               WHERE id=:id");
           $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
           $consulta->bindValue(':titulo',$this->titulo, PDO::PARAM_INT);
           $consulta->bindValue(':anio', $this->año, PDO::PARAM_STR);
           $consulta->bindValue(':cantante', $this->cantante, PDO::PARAM_STR);
           return $consulta->execute();
    }


    public function InsertarUsuario()
    {
                
                $d=strtotime($this->fechaRegistroString);
                $fechaConFormato=date("Y-m-d", $d);
               $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
               $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (id,nombre,apellido,clave,mail,localidad,fecha_de_registro) values ('$this->id','$this->nombre','$this->apellido','$this->clave','$this->mail','$this->localidad','$fechaConFormato')");
               $consulta->execute();
               return $objetoAccesoDato->RetornarUltimoIdInsertado();         
    }

    public function InsertarUsuarioParametros()
    {
               $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
               $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (id,nombre,apellido,clave,mail,localidad,fecha_de_registro) values(:nombre,:apellido,:clave,:mail,:localidad,:fecha)");
               $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_INT);
               $consulta->bindValue(':apellido',$this->apellido, PDO::PARAM_INT);
               $consulta->bindValue(':clave',$this->clave, PDO::PARAM_INT);
               $consulta->bindValue(':mail',$this->mail, PDO::PARAM_INT);
               $consulta->bindValue(':localidad',$this->localidad, PDO::PARAM_INT);
               $consulta->bindValue(':fecha',$this->fechaRegistro, PDO::PARAM_INT);
               $consulta->execute();		
               return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    
    public static function TraerListaUsuarios()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select id,nombre,apellido,clave,mail,localidad,fecha_de_registro as fechaRegistroString from usuario");
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
    }

   public static function TraerUsuario($id) 
   {
           $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
           $consulta =$objetoAccesoDato->RetornarConsulta("select id,nombre,apellido,clave,mail,localidad,fecha_de_registro as fechaRegistro from usuario where id = $id");
           $consulta->execute();
           $cdBuscado= $consulta->fetchObject('usuario');
           return $cdBuscado;				     
   }

}


?>


