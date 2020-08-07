<?php

spl_autoload_register(function ($nomeClasse)
{
	//echo $nomeClasse . "<br>";
	
	$dirClass = "class";
	$filename = $dirClass . DIRECTORY_SEPARATOR . $nomeClasse . ".php";
	
	if(file_exists($filename))
	{	
		require_once($filename);
	}
});


?>