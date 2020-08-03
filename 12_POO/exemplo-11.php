<?php

//autoload

function __autoload($nomeClass){
	
	var_dump($nomeClass);
	require_once("$nomeClass.php");
	
}


$carro = new DelRey();
$carro->acelerar(80);


?>