<?php

//escopo de variaveis

$nome = "Danilo";

function teste()
{
	global $nome;
	echo $nome;
}

function teste2()
{
	$nome = "Joao";
	echo $nome . " agora no teste2";
}

teste();
teste2();


?>