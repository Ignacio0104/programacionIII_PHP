<?php

class Helado{

    public string $sabor;
    public float $precio;
    public string $tipo;
    public int $stock;

    public function __construct($id,$sabor,$precio,$tipo,$stock)
    { 
        $listaDeTipos = ["agua","crema"];

        $this->id = $id;      
        $this->sabor = $sabor; 
        $this->precio = $precio;
        $this->tipo = $listaDeTipos[$tipo];
        $this->stock = $stock;
    }

    public function GuardarImagen(){  
        $nombreDeArchivo = "$this->tipo - $this->sabor";
        if(!file_exists(".".DIRECTORY_SEPARATOR."ImagenesDeHelados".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR))
        {
            mkdir(".".DIRECTORY_SEPARATOR."ImagenesDeHelados".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR, 0777, true);
        }
        $destino = "ImagenesDeHelados/" . $nombreDeArchivo . ".jpg";
        $tmpName = $_FILES["imagen"]["tmp_name"];
        if (move_uploaded_file($tmpName, $destino)) {
            echo "La foto se guardó correctamente\n";
            return true;
        } else {
           echo "La foto no pudo guardarse";
           return false;
        }
    }
    public function Mostrar(){
        echo "$this->id,$this->sabor,$this->precio,$this->tipo, $this->stock";
    }

}


?>