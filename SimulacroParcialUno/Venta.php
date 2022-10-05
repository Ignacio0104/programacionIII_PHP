<?php

class Venta{

    public int $numeroDePedido;
    public int $id;
    public string $mailUsuario;
    public string $sabor;
    public string $tipo;
    public int $cantidad;
    public string $fechaDePedido;

    public function __construct($id,$mailUsuario,$sabor,$tipo,$cantidad, $numeroDePedido,$fechaDePedido="")
    { 
        $this->id = $id;   
        $this->mailUsuario = $mailUsuario;   
        $this->sabor = $sabor; 
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;    
        if($fechaDePedido==""){
            $fechaActual = new DateTime(date('d-m-y h:i:s'));
            $this->fechaDePedido = $fechaActual->format('y-m-d');
        }else{
            $this->fechaDePedido = $fechaDePedido;
        }    
        $this->numeroDePedido = $numeroDePedido;
    }

    public function Mostrar(){
        echo "$this->numeroDePedido,$this->id,$this->mailUsuario,$this->sabor, $this->tipo,$this->cantidad,$this->fechaDePedido";
    }
}

?>