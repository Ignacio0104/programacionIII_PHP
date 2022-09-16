<?php


class Auto
{
    private string $color;
    private float $precio;
    private string $marca;
    private ?DateTime $fecha;


    public function __construct($color,$marca,$precio=60000,$fecha=NULL)
    {   
        $this->color = $color;
        $this->marca = $marca; 
        $this->precio = $precio;
        if(!is_null($fecha))
        {
            $this->fecha=$fecha;
        }else
        {
            $this->fecha=new DateTime('now');
        }
    }

    public function AgregarImpuestos (float $impuesto)
    {
        $this->precio = $this->precio+$impuesto;
    }

    public function MostrarAuto (Auto $autoAMostrar)
    {
        echo "Color: ",$autoAMostrar->color, " Precio: $", $autoAMostrar->precio,
        " Marca: ",$autoAMostrar->marca, " Fecha: ", $autoAMostrar->fecha->format("m-d-y");
    }

    public function InformacionAuto (Auto $autoAMostrar)
    {
        $cadenaTexto="";
        $cadenaTexto.="$autoAMostrar->color,$autoAMostrar->precio,$autoAMostrar->marca,";
        $cadenaTexto.= $autoAMostrar->fecha->format('m/d/y');
        return $cadenaTexto;
    }

    public function Equals (Auto $autoUno, Auto $autoDos)
    {
        if(strcmp($autoUno->marca,$autoDos->marca)==0)
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function Add (Auto $autoUno, Auto $autoDos)
    {
        if($this->Equals($autoUno,$autoDos))
        {   
            if(strcmp($autoUno->color,$autoDos->color)==0)
            {
                return $autoUno->precio + $autoDos->precio;
            }else
            {
                echo "<br> Los autos son de la misma marca, pero no el mismo color<br>No se pudo realizar la operacion";
            }         
        } else
        {
            echo "<br> Los autos no son de la misma marca<br>No se pudo realizar la operacion";
        }     
        return 0;
    }

    public function GuardarAuto($automoviles)
    {
        $archivo = fopen("autos.csv","w");
        foreach ($automoviles as $auto)
        {
            fwrite($archivo,$auto->InformacionAuto($auto) . PHP_EOL);
        }
        fclose($archivo);
    }

    public function LeerAutos()
    {
        $archivo = fopen("autos.csv","r");
        $arrayAtributos = array();
        $arrayDeAutos = array();

        while(!feof($archivo))
        {
            $arrayAtributos=fgetcsv($archivo);
            if(!empty($arrayAtributos))
            {
                $autoAuxiliar = new Auto($arrayAtributos[0],$arrayAtributos[2],(float)$arrayAtributos[1],
                new DateTime($arrayAtributos[3]));
                    array_push($arrayDeAutos,$autoAuxiliar);
            }
        }
        return $arrayDeAutos;
    }
}

?>