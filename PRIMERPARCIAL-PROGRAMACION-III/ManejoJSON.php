<?php

class ManejoJSON{

    public static function GuardarListaJSON($array,$archivo)
    {
        $archivo = fopen($archivo,"w");
        $confirmacion = false; 
        
        if(fwrite($archivo,json_encode($array,JSON_PRETTY_PRINT). PHP_EOL)!=false)
        {
            $confirmacion = true;
        }  
        fclose($archivo);
        return $confirmacion; 
    }

    public static function LeerListaJSON($nombreArchivo)
    {
        if(file_exists($nombreArchivo))
        {
            $archivo = fopen($nombreArchivo,"r");
            $arrayAtributos = array();

                if(filesize($nombreArchivo)>0)
                {
                    $json = fread($archivo,filesize($nombreArchivo));
                    $arrayAtributos=json_decode($json,true);
                    fclose($archivo);      //Agregado              
                    return $arrayAtributos;  
                }
        }else{
            echo "El archivo no existe\n";
        }   
    }
}


?>