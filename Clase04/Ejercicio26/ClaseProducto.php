<?php

use Producto as GlobalProducto;

class Producto
{
    public int $codigoBarras;
    public string $nombre;
    public string $tipo;
    public int $stock;
    public float $precio;

    public function __construct($codigoBarras,$nombre,$tipo,$stock,$precio)
    {       
        $this->codigoBarras = $codigoBarras; 
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->stock = $stock;
        $this->precio = $precio;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getCodigo()
    {
        return $this->codigoBarras;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock ($cantidad)
    {
        $this->stock = $cantidad;
    }

    public function getPrecio()
    {
        return $this->precio;
    }
    public function MostrarInformacion(Producto $producto)
    {
        echo "Producto: $producto->nombre | Codigo: $producto->codigoBarras | Tipo: $producto->tipo \n ";
        echo "Stock: $producto->stock | Precio $ $producto->precio ";

    }

    public function InformacionProducto(Producto $producto)    
    {
        return "$producto->codigoBarras,$producto->nombre,$producto->tipo,$producto->stock,$producto->precio";
    }

    
    /*public function GuardarProductoJSON (Producto $producto)
    {
        $archivo = fopen("productos.json","a");//Sobreescribo cada vez que guardo
        $confirmacion = false; 
        if(fwrite($archivo,json_encode($producto->InformacionProducto($producto)). PHP_EOL)!=false)
        {
            $confirmacion = true;
        }
        fclose($archivo);
        return $confirmacion;
    }*/
     
    public function GuardarListaProductosJSON ($arrayProductos)
    {
        $archivo = fopen("productos.json","w");
        $confirmacion = false; 
        
        if(fwrite($archivo,json_encode($arrayProductos,JSON_PRETTY_PRINT). PHP_EOL)!=false)
        {
            $confirmacion = true;
        }  
        fclose($archivo);
        return $confirmacion;
    }

    public static function LeeProductosListaJSON($nombreArchivo)
    {
        $archivo = fopen($nombreArchivo,"r");
        $arrayAtributos = array();
        $arrayDeProductos = array();

        $json = fread($archivo,filesize($nombreArchivo));
        $arrayAtributos=json_decode($json,true);
          
        if(!empty($arrayAtributos))
        {
            foreach ($arrayAtributos as $productoJson)
            {
                $productoAuxiliar = new Producto($productoJson["codigoBarras"],$productoJson["nombre"],
                $productoJson["tipo"],$productoJson["stock"],$productoJson["precio"]);
                array_push($arrayDeProductos,$productoAuxiliar);
            }
        }
        fclose($archivo);  
        return $arrayDeProductos;
    }

    public static function ConseguirUltimoID($listaDeProductos)
    {
        $idMaxima = 1000;
        if(count($listaDeProductos)>0)
        {
            foreach ($listaDeProductos as $producto)
            {
                if($producto->getCodigo()>$idMaxima)
                {
                    $idMaxima =$producto->getCodigo();
                }
            }
        }

        return (int)$idMaxima;
    }

    public static function BuscarProducto($listaDeProductos,$productoIngresado)
    {
        foreach ($listaDeProductos as $producto)
        {
            if(strcmp($producto->getNombre(),$productoIngresado->getNombre())==0)
            {
                return $producto;
            }
        }

        return null;
    }

    
    public static function BuscarProductoPorId($listaDeProductos,$idProducto)
    {
        foreach ($listaDeProductos as $producto)
        {
            if($producto->getCodigo()==$idProducto)
            {
                return $producto;
            }
        }

        return null;
    }

}

?>