<?php

class Usuario
{
    public $id;
    public $mail;
    public $clave;
    public $perfil_usuario;
    public $fechaBaja;

    public function crearUsuario()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuarios (mail, clave,perfil_usuario) 
        VALUES (:mail, :clave, :perfil_usuario)");
        $claveHash = password_hash($this->clave, PASSWORD_DEFAULT);
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $claveHash);
        $consulta->bindValue(':perfil_usuario', $this->perfil_usuario, PDO::PARAM_STR);
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