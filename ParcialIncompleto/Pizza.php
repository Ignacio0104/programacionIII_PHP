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

    public function Mostrar(){
        echo "$this->id,$this->sabor,$this->precio,$this->tipo, $this->cantidad";
    }
}

?>