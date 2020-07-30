<?php

//include "inc/exemplo-01.php";
//include_once "inc/exemplo-01.php";

require "inc/exemplo-01.php";
require_once "inc/exemplo-01.php";

//require obriga que o arquivo exista e esteja funcionando corretamente, se não estiver gera um erro fatal.

$resultado = somar(10,25);

echo $resultado;

?>