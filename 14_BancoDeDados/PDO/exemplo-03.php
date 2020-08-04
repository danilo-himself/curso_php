<?php

$conn = new PDO("mysql:dbname=dbphp7;host=localhost", "root", "");

$stmt = $conn->prepare("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASS WHERE idusuario = :ID");

$id = 2;
$login = "JOAO";
$password = "qwerty";

$stmt->bindParam(":LOGIN", $login);
$stmt->bindParam(":PASS", $password);
$stmt->bindParam(":ID", $id);

$stmt->execute();

echo "Alterado OK!";


?>