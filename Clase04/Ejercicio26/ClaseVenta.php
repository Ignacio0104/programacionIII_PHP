<?php
include_once "ClaseProducto.php";

class Venta
{
    public int $producto;
    public string $usuario;
    public int $cantidad;

    public function __construct($usuario,$codigoDeBarras,$cantidad)
    {               
        $this->usuario = $usuario;
        $this->producto = $codigoDeBarras;
        $this->cantidad = $cantidad;

    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function MostrarInformacion($listaDeProductos,Venta $venta)
    {
        echo "Usuario: $venta->usuario\n";
        $producto = $venta->BuscarProductoPorId($listaDeProductos,$venta->producto);
        if( $producto!= null)
        {
            $producto->MostrarInformacion($producto);
        }else{
            echo "Hubo un error en la búsqueda del producto \n";
        }
        echo "Cantidad: $venta->cantidad";
    }

    public function InformacionVenta(Venta $venta)    
    {
        $cadenaDeTexto = "$venta->usuario,";
        $cadenaDeTexto.= $venta->producto;
        $cadenaDeTexto.= ",$venta->cantidad";
        return $cadenaDeTexto;
    }
   
    public function GuardarVentaJSON (Venta $venta)
    {
        $archivo = fopen("ventas.json","a");
        $confirmacion = false; 
        if(fwrite($archivo,json_encode($venta->InformacionVenta($venta)). PHP_EOL)!=false)
        {
            $confirmacion = true;
        }
        fclose($archivo);
        return $confirmacion;
    }

    public function GuardarListaVentasJSON ($arrayVentas)
    {
        $archivo = fopen("ventas.json","w");
        $confirmacion = false; 
        
        if(fwrite($archivo,json_encode($arrayVentas,JSON_PRETTY_PRINT). PHP_EOL)!=false)
        {
            $confirmacion = true;
        }  
        fclose($archivo);
        return $confirmacion;
    }


    public static function LeerVentasListaJSON($nombreArchivo)
    {
        $archivo = fopen($nombreArchivo,"r");
        $arrayAtributos = array();
        $arrayDeVentas = array();

        $json = fread($archivo,filesize($nombreArchivo));
        $arrayAtributos=json_decode($json,true);
          
        if(!empty($arrayAtributos))
        {
            foreach ($arrayAtributos as $ventasJson)
            {
                $ventaAux = new Venta($ventasJson["usuario"],$ventasJson["producto"],$ventasJson["cantidad"]);
                array_push($arrayDeVentas,$ventaAux);
            }
        }
        fclose($archivo);  
        return $arrayDeVentas;
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

    public function BuscarProducto($listaDeProductos,$productoIngresado)
    {
        foreach ($listaDeProductos as $producto)
        {
            if($producto->getNombre()==$productoIngresado->getNombre())
            {
                return $producto;
            }
        }

        return null;
    }

    public function BuscarProductoPorId($listaDeProductos,$id)
    {
        foreach ($listaDeProductos as $producto)
        {
            if($producto->getCodigo()==$id)
            {
                return $producto;
            }
        }

        return null;
    }

    public function ConfirmarVenta($listaDeProductos,$listaDeUsuarios,$producto,$usuario)
    {
        $productoEnLista = Producto::BuscarProductoPorId($listaDeProductos,$producto);
    
        if($productoEnLista != null && $productoEnLista->getStock() - $this->cantidad > 0
        && Usuario::BuscarUsuario($listaDeUsuarios,$usuario)!= null)
            {
                $productoEnLista->setStock($productoEnLista->getStock() - $this->cantidad);
                echo "Venta realizada con exito\n";
            }else
            {
                echo "No se pudo confirmar la venta\n";
            }
    }


}

?>