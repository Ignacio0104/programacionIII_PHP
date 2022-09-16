
Aplicación No 1 (Sumar números)
Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no
supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
se sumaron.


<?php 
$acumulador=0;
$contador=0;

echo"<br>";
for($i=1;$acumulador<1000;$i++)
{
    echo "Numero: ",$i,"</br>";
    $acumulador+=$i;
}
echo "Se sumaron ", $i, " números</br>";
echo "El total fue de ", $acumulador;
?>