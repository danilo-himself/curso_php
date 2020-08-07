<?php

$frase = "A repetição é a mãe da retenção.";

$palavra = "mãe";

$q = strpos($frase, $palavra);

//var_dump($q);

$texto = substr($frase, 0, $q);

var_dump($texto);

echo "<br>";

$texto2 = substr($frase, $q + strlen($palavra), strlen($frase));

var_dump($texto2);

?>