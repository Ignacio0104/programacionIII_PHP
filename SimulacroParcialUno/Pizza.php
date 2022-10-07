<?php

class Pizza{

    public int $id;
    public string $sabor;
    public float $precio;
    public string $tipo;
    public int $cantidad;

    public function __construct($id,$sabor,$precio,$tipo,$cantidad)
    { 
        $this->id = $id;      
        $this->sabor = $sabor; 
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
    }

    public function GuardarImagen(){  
        $nombreDeArchivo = "$this->tipo - $this->sabor";
        $destino = "ImagenesDePizzas/" . $nombreDeArchivo . ".jpg";
        $tmpName = $_FILES["imagen"]["tmp_name"];
        if (move_uploaded_file($tmpName, $destino)) {
            echo "La foto se guardó correctamente\n";
            return true;
        } else {
           echo "La foto no pudo gurdarse";
           return false;
        }
    }
    public function Mostrar(){
        echo "$this->id,$this->sabor,$this->precio,$this->tipo, $this->cantidad";
    }
}

?>