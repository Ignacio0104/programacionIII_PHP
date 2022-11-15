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

    public static function obtenerVentaParametros($clima,$fechaInicio,$fechaFinal)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventasHortalizas INNER JOIN hortalizas 
        ON ventasHortalizas.idHortaliza = hortalizas.id 
        WHERE hortalizas.clima = :clima 
        AND ventasHortalizas.fechaCompra > :fechaInicio AND ventasHortalizas.fechaCompra < :fechaFinal");
        $consulta->bindValue(':clima', $clima, PDO::PARAM_STR);
        $consulta->bindValue(':fechaInicio', $fechaInicio, PDO::PARAM_STR);
        $consulta->bindValue(':fechaFinal', $fechaFinal, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'VentaHortaliza');
    }

    
    public static function obtenerVentaPorNombre($hortaliza)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta(
        "SELECT mail FROM usuarios INNER JOIN ventasHortalizas 
        ON usuarios.id = ventasHortalizas.idCliente
        INNER JOIN hortalizas 
        ON ventasHortalizas.idHortaliza = hortalizas.id 
        WHERE hortalizas.nombre =:hortaliza");
        $consulta->bindValue(':hortaliza', $hortaliza, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

}