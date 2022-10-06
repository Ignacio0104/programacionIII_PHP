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

    public static function BuscarPizza($listaDePizzas,$sabor,$tipo)
    {
        if(count($listaDePizzas)>0){
            foreach ($listaDePizzas as $pizza)
            {
                if((strcmp($pizza->sabor,$sabor)==0)&&(strcmp($pizza->tipo,$tipo)==0))
                {
                    return $pizza;
                }
            }
        }
        return null;
    }
}


?>