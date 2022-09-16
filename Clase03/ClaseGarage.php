<?php

use Garage as GlobalGarage;

include_once "ClaseAuto.php";

class Garage
{
    private string $_razonSocial;
    private float $_precioPorHora;
    private $_autos;

    public function __construct($_razonSocial,$_precioPorHora=25)
    {
        $this->_razonSocial=$_razonSocial;
        $this->_precioPorHora=$_precioPorHora;
        $this->_autos= array();
    }

    public function MostrarGarage()
    {
        echo "Razón social: ", $this->_razonSocial, " Precio por hora: $", $this->_precioPorHora, "<br>";
        foreach($this->_autos as $auto)
        {
            $auto->MostrarAuto($auto);
            echo "<br>";
        }
    }

    public function InformacionGarage(Garage $garage)
    {
        $cadenaTexto="$this->_razonSocial,$this->_precioPorHora,"; 
        for ($i=0;$i<count($garage->_autos);$i++)
        {
            $cadenaTexto.=$garage->_autos[$i]->InformacionAuto($garage->_autos[$i]);
            if($i<count($garage->_autos)-1)
            {
                $cadenaTexto.=",";
            }
        }    
        return $cadenaTexto;
    }


    public function Equals(Auto $auto,Garage $garage)
    {
        if($auto !=null && $garage != null)
        {
            foreach($garage->_autos as $valor)
            {
                if($auto->Equals($auto,$valor))
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function Add (Auto $auto,Garage $garage)
    {
        if($auto !=null && $garage != null)
        {
            if(!$garage->Equals($auto,$garage))
            {
                array_push($garage->_autos,$auto);
            }else
            {
                echo "El vehiculo ya se encuentra en el garage";
            }
        }else
        {
            echo  "El vehiculo no existe";
        }
    }

    public function Remove (Auto $auto,Garage $garage)
    {
        if($auto !=null && $garage != null)
        {
            if($garage->Equals($auto,$garage))
            {
                $key = array_search($auto, $garage->_autos, true);
                if ($key !== false) {
                    unset($garage->_autos[$key]);//Esto borra la variable pero no reacomoda el array. Mejor SLICE
                }else
                {
                    echo "El vehiculo no está en el garage";
                }
            }
        }else
        {
            echo "El vehiculo no existe";
        }
    }

    public function GuardarGarage ($garages)
    {
        $archivo = fopen("garage.csv","w");
        foreach ($garages as $garage)
        {
            fwrite($archivo,$garage->InformacionGarage($garage) . PHP_EOL);
        }
        fclose($archivo);
    }

    public function LeerGarages()
    {
        $archivo = fopen("garage.csv","r");
        $arrayAtributosAutos = array();
        $arrayDeGarage= array();


        while(!feof($archivo))
        {
            $arrayAtributos=fgetcsv($archivo);
            $indice=0;
            if(!empty($arrayAtributos))
            {
                $garageAuxiliar = new Garage($arrayAtributos[0],(float)$arrayAtributos[1]);
                for($i=2;$i<count($arrayAtributos);$i++)
                {
                    array_push($arrayAtributosAutos,$arrayAtributos[$i]);
                }

                for ($i=0;$i<count($arrayAtributosAutos)/4;$i++)
                {              
                    $autoAuxiliar = new Auto($arrayAtributosAutos[$indice],$arrayAtributosAutos[$indice+2],
                    (float)$arrayAtributosAutos[$indice+1],new DateTime($arrayAtributosAutos[$indice+3]));
                    $garageAuxiliar->Add($autoAuxiliar,$garageAuxiliar);
                    $indice=$indice+4;
                }   
                $arrayAtributosAutos = array(); 
                array_push($arrayDeGarage,$garageAuxiliar);                      
            }
        }
        return $arrayDeGarage;
    }
}
?>