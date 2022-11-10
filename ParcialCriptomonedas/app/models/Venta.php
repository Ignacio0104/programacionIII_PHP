<?php

class Venta
{
    public $id;
    public $idCripto;
    public $mailUsuario;
    public $fechaCompra;
    public $cantidad;
    public $URLImagen;

    public function crearVenta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO ventas (idCripto, mailUsuario,fechaCompra,cantidad,URLImagen) 
        VALUES (:idCripto, :mailUsuario, :fechaCompra,:cantidad, :URLImagen)");
        $fecha = date("Y-m-d H:i:s");
        $consulta->bindValue(':fechaCompra', $fecha);
        $consulta->bindValue(':mailUsuario', $this->mailUsuario, PDO::PARAM_STR);
        $consulta->bindValue(':idCripto', $this->idCripto, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);
        $consulta->bindValue(':URLImagen', $this->URLImagen, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }

    public static function obtenerVenta($idVenta)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventas WHERE id = :idVenta");
        $consulta->bindValue(':idVenta', $idVenta, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Venta');
    }

}