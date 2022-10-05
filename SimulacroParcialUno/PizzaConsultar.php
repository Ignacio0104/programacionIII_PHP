<?php

function BuscarPizzaPOST($listaDePizzas,$sabor,$tipo)
{
    if(count($listaDePizzas)>0){
        foreach ($listaDePizzas as $pizza)
        {
            if((strcmp($pizza->sabor,$sabor)==0)&&(strcmp($pizza->tipo,$tipo)==0))
            {
                return "Si hay!";
            }
        }
    }
    return "No existe el tipo o el sabor";
}
?>