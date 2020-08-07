<?php

function trataNome($nome)
{
	if(!$nome)
	{
		throw new Exception("Nenhum nome informado", 1);
	}
	
	echo ucfirst($nome) . "<br>";
}


try
{
	trataNome("JOAO");
	trataNome("");
}
catch(Exception $e)
{
	echo json_encode(array(
		"message"=>$e->getMessage(),
		"line"=>$e->getLine(),
		"file"=>$e->getFile()
	));
}
finally
{
	echo "Executou bloco try!";
}


?>