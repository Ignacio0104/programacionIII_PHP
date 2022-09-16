<?php
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
}
?>