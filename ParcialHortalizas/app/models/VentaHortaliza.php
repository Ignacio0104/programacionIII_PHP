<?php

class VentaHortaliza
{
    public $id;
    public $idCliente;
    public $idHortaliza;
    public $fechaCompra;
    public $cantidad;
    public $tipoUnidad;
    public $URLImagen;

    public function crearVenta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO ventasHortalizas (idHortaliza,  fechaCompra,cantidad,tipoUnidad,URLImagen,idCliente) 
        VALUES (:idHortaliza,:fechaCompra, :cantidad,:tipoUnidad, :URLImagen,:idCliente)");
        $fecha = date("Y-m-d H:i:s");
        $consulta->bindValue(':fechaCompra', $fecha);
        $consulta->bindValue(':tipoUnidad', $this->tipoUnidad, PDO::PARAM_STR);
        $consulta->bindValue(':idHortaliza', $this->idHortaliza, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);
        $consulta->bindValue(':idCliente', $this->idCliente, PDO::PARAM_STR);
        $consulta->bindValue(':URLImagen', $this->URLImagen, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

}