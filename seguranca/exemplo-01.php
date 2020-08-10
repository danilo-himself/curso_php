<?php

if($_SERVER["REQUEST_METHOD"] === 'POST')
{
	//tratando com escape
	$cmd = escapeshellcmd($_POST["cmd"]);
	
	var_dump($cmd);
	
	echo "<pre>";

	//$comando = system("dir C:", $retorno);
	$comando = system($cmd, $retorno);

	echo "</pre>";
}



?>

<form method="post">
	<input type="text" name ="cmd">
	<button type="submit">Enviar</button>
</form>