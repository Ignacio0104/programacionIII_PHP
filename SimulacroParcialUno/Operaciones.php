<?php

class Operaciones{

    public static function ConseguirIDMaximo($lista,$numeroPartida)
    {
        $idMaxima = $numeroPartida;
        if(count($lista)>0)
        {
            foreach ($lista as $item)
            {
                if($item->id>$idMaxima)
                {
                    $idMaxima =$item->id;
                }
            }
        }
        return $idMaxima;     
    }
}


?>