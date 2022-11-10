<?php

class Criptomoneda
{
    public $id;
    public $precio;
    public $nombre;
    public $URLImagen;
    public $nacionalidad;
    public $fechaBaja;

    public function crearCriptomoneda()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO criptomonedas (precio,nombre,URLImagen,nacionalidad) 
        VALUES (:precio, :nombre, :URLImagen, :nacionalidad)");
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':URLImagen', $this->URLImagen, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM criptomonedas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Criptomoneda');
    }

    public static function obtenerCriptomoneda($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM criptomonedas WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Criptomoneda');
    }


    public static function obtenerCriptomonedaPorPais($pais)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM criptomonedas WHERE nacionalidad = :pais");
        $consulta->bindValue(':pais', $pais, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Criptomoneda');
    }


    public static function obtenerCriptomonedaPorId($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM criptomonedas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Criptomoneda');
    }

    public static function modificarCriptomoneda($cripto)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE criptomonedas SET 
        nombre = :nombre, precio=:precio , 
        URLImagen= :URLImagen, nacionalidad= :nacionalidad WHERE id = :id");
        $consulta->bindValue(':nombre', $cripto->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $cripto->precio, PDO::PARAM_STR);
        $consulta->bindValue(':URLImagen', $cripto->URLImagen, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $cripto->nacionalidad, PDO::PARAM_STR);
        $consulta->bindValue(':id', $cripto->id, PDO::PARAM_STR);
        $consulta->execute();
    }

    public static function borrarCriptomoneda($idCripto)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE criptomonedas SET fechaBaja = :fechaBaja 
        WHERE id = :id");
        $fecha = date("Y-m-d H:i:s");
        $consulta->bindValue(':id', $idCripto, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', $fecha);
        $consulta->execute();
    }


}