<?php

class Pessoa{
	
	public $nome;
	
	public function falar()
	{
		return "O meu nome é " . $this->nome;
	}
	
}

$danilo = new Pessoa();
$danilo->nome = "Danilo Lima";

echo $danilo->falar();

?>