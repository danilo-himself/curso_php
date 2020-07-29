<?php


	//arrays super globais $_GET, $_POST, $_SESSION e $_SERVER

	$nome = (int)$_GET["a"];

	//var_dump($nome);
	
	$ip = $_SERVER["REMOTE_ADDR"];
	
	//echo $ip;
	
	$scriptName = $_SERVER["SCRIPT_NAME"];
	
	echo $scriptName;

?>