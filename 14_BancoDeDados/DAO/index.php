<?php

require_once("config.php");

/*
$sql = new Sql();

$usuarios = $sql->select("Select * from tb_usuarios");

echo json_encode($usuarios);
*/


//carrega um usuario
//$pessoa = new Usuario();
//$pessoa->loadById(4);
//echo $pessoa;

//carrega uma lista de usuarios
//$lista = Usuario::getList();
//echo json_encode($lista);

//carrega lista usuario buscando pelo login
//$search = Usuario::search("Jo");
//echo json_encode($search);

//carrega um usuarioo usando o login e a senha
$usuario = new Usuario();
$usuario->login("Jose","123456");

echo $usuario;

?>