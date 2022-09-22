<?php
include_once "ClaseProducto.php";

class Venta
{
    public Producto $producto;
    public string $usuario;
    public int $cantidad;

    public function __construct($usuario,$codigoDeBarras,$nombreProducto,$tipoProducto
    ,$stockProducto,$precioProducto,$cantidad)
    {               
        $this->usuario = $usuario;
        $this->producto = new Producto($codigoDeBarras,$nombreProducto,$tipoProducto,$stockProducto,$precioProducto); 
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

    public function MostrarInformacion(Venta $venta)
    {
        echo "Usuario: $venta->usuario\n";
        $venta->producto->MostrarInformacion($this->producto);
        echo "Cantidad: $venta->cantidad";
    }

    public function InformacionVenta(Venta $venta)    
    {
        $cadenaDeTexto = "$venta->usuario,";
        $cadenaDeTexto.= $venta->producto->InformacionProducto($this->producto);
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
     
    public static function GuardarListaVentasJSON ($ventas) //Modificarlo a que reciba array
    {
        $archivo = fopen("ventasEnJSON.json","w");
        $confirmacion = false; 
        
        if(fwrite($archivo,json_encode($ventas))!=false)
        {
            $confirmacion = true;
        }  
        fclose($archivo);
        return $confirmacion;
    }

    public static function LeerVentasJSON($nombreArchivo)
    {
        $archivo = fopen($nombreArchivo,"r");
        $arrayAtributos = array();
        $arrayDeVentas = array();

       while(!feof($archivo))
        {
            $arrayAtributos=fgetcsv($archivo);           
            if(!empty($arrayAtributos))
            {
                $arraySeparado = explode(",",$arrayAtributos[0]);
                $ventaAuxiliar = new Venta($arraySeparado[0],
                $arraySeparado[1],$arraySeparado[2],$arraySeparado[3],$arraySeparado[4],$arraySeparado[5],
                $arraySeparado[6]);
                    array_push($arrayDeVentas,$ventaAuxiliar);
            }
        }
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

    public function ConfirmarVenta($listaDeProductos,$listaDeUsuarios,$producto,$usuario)
    {
        $productoEnLista = Producto::BuscarProducto($listaDeProductos,$producto);
    
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