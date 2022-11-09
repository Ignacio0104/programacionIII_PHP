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
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($mail)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE mail = :mail");
        $consulta->bindValue(':mail', $mail, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

    public static function modificarUsuario($usuario)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET 
        clave = :clave, fechaBaja=:fechaBaja , 
        perfil_usuario= :perfilUsuario WHERE mail = :mail");
        $claveHash = password_hash($usuario->clave, PASSWORD_DEFAULT);
        $consulta->bindValue(':mail', $usuario->mail, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $claveHash, PDO::PARAM_STR);
        if($usuario->fechaBaja != null)
        {
            $consulta->bindValue(':fechaBaja', $usuario->fechaBaja, PDO::PARAM_INT);
        }else{
            $consulta->bindValue(':fechaBaja', null, PDO::PARAM_INT);
        }
        if($usuario->perfil_usuario!=null)
        {
            $consulta->bindValue(':perfilUsuario', $usuario->perfil_usuario, PDO::PARAM_INT);
        }else{
            $consulta->bindValue(':perfilUsuario', null, PDO::PARAM_INT);
        }
        $consulta->execute();
    }

    public static function borrarUsuario($mail)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET fechaBaja = :fechaBaja WHERE mail = :mail");
        $fecha = date("Y-m-d H:i:s");
        $consulta->bindValue(':mail', $mail, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', $fecha);
        $consulta->execute();
    }

}