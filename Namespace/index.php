<?php

require_once("config.php");

use Cliente\Cadastro;

$cad = new Cadastro();
$cad->setNome("Djalma");
$cad->setEmail("Djalma@gmail.com");
$cad->setSenha("123");

$cad->registraVenda();

echo $cad;

?>