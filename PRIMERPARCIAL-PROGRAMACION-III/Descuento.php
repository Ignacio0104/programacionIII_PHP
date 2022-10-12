
<?php

class Descuento{

    public int $idPedido;
    public int $id;
    public float $porcentajeDescuento;
    public bool $usado;

    public function __construct($id,$idPedido,$porcentajeDescuento,$usado)
    { 
        $this->id = $id;   
        $this->idPedido = $idPedido;   
        $this->porcentajeDescuento = $porcentajeDescuento; 
        $this->usado = $usado;
    }
}

?>