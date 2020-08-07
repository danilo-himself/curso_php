<?php

//"metodos magicos"

class Endereco
{
	
	private $logradouro;
	private $numero;
	private $cidade;
	
	public function __construct($a, $b, $c)
	{
		$this->logradouro = $a;
		$this->numero = $b;
		$this->cidade = $c;
	}
	
	public function __destruct()
	{
		var_dump("DESTRUIR");
	}
	
	
	public function __toString()
	{
		return $this->logradouro . "," . $this->numero . ", " . $this->cidade;
	}
}

$meuendereco = new Endereco("Rua A", 10, "Salvador");

//var_dump($meuendereco);

echo $meuendereco;

unset($meuendereco);


?>