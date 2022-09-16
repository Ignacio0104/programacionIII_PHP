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
    
}

?>