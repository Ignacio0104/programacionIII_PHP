<?php

class Producto
{
    private int $codigoBarras;
    private string $nombre;
    private string $tipo;
    private int $stock;
    private float $precio;

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

    
    public function GuardarProductoJSON (Producto $producto)
    {
        $archivo = fopen("productos.json","a");//Sobreescribo cada vez que guardo
        $confirmacion = false; 
        if(fwrite($archivo,json_encode($producto->InformacionProducto($producto)). PHP_EOL)!=false)
        {
            $confirmacion = true;
        }
        fclose($archivo);
        return $confirmacion;
    }
     
    public function GuardarListaProductosJSON ($arrayProductos)
    {
        $archivo = fopen("productos.json","w");//Sobreescribo cada vez que guardo
        $confirmacion = false; 
        foreach ($arrayProductos as $producto)
        {
            if(fwrite($archivo,json_encode($producto->InformacionProducto($producto)). PHP_EOL)!=false)
            {
                $confirmacion = true;
            }
        }
        fclose($archivo);
        return $confirmacion;
    }

    public static function LeeUsuariosJSON($nombreArchivo)
    {
        $archivo = fopen($nombreArchivo,"r");
        $arrayAtributos = array();
        $arrayDeUsuarios = array();

       while(!feof($archivo))
        {
            $arrayAtributos=fgetcsv($archivo);           
            if(!empty($arrayAtributos))
            {
                $arraySeparado = explode(",",$arrayAtributos[0]);
                $usuarioAuxiliar = new Producto($arraySeparado[0],$arraySeparado[1],$arraySeparado[2],$arraySeparado[3],$arraySeparado[4]);
                    array_push($arrayDeUsuarios,$usuarioAuxiliar);
            }
        }
        return $arrayDeUsuarios;
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