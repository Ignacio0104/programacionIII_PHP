<?php

class Hortaliza
{
    public $id;
    public $precio;
    public $nombre;
    public $URLImagen;
    public $clima;
    public $tipoUnidad;
    public $fechaBaja;

    public function crearHortaliza()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO hortalizas (precio,nombre,URLImagen,clima,tipoUnidad) 
        VALUES (:precio, :nombre, :URLImagen, :clima, :tipoUnidad)");
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':URLImagen', $this->URLImagen, PDO::PARAM_STR);
        $consulta->bindValue(':clima', $this->clima, PDO::PARAM_STR);
        $consulta->bindValue(':tipoUnidad', $this->tipoUnidad, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM hortalizas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Hortaliza');
    }

    public static function obtenerHortalizaPorClima($clima)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM hortalizas WHERE clima = :clima");
        $consulta->bindValue(':clima', $clima, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Hortaliza');
    }

    public static function obtenerHortalizaPorId($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM hortalizas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Hortaliza');
    }

    public static function borrarHortaliza($idHortaliza)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE hortalizas SET fechaBaja = :fechaBaja 
        WHERE id = :id");
        $fecha = date("Y-m-d H:i:s");
        $consulta->bindValue(':id', $idHortaliza, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', $fecha);
        $consulta->execute();
    }

    public static function modificarHortaliza($hortaliza)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE hortalizas SET 
        nombre = :nombre, precio=:precio , 
        URLImagen= :URLImagen, clima= :clima, tipoUnidad = :tipoUnidad WHERE id = :id");
        $consulta->bindValue(':nombre', $hortaliza->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $hortaliza->precio, PDO::PARAM_STR);
        $consulta->bindValue(':URLImagen', $hortaliza->URLImagen, PDO::PARAM_STR);
        $consulta->bindValue(':clima', $hortaliza->clima, PDO::PARAM_STR);
        $consulta->bindValue(':tipoUnidad', $hortaliza->tipoUnidad, PDO::PARAM_STR);
        $consulta->bindValue(':id', $hortaliza->id, PDO::PARAM_STR);
        $consulta->execute();
    }

}