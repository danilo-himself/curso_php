<?php

$conn = new PDO("mysql:dbname=dbphp7;host=localhost", "root", "");

$stmt = $conn->prepare("INSERT INTO tb_usuarios (deslogin, dessenha) values (:LOGIN, :PASS)");

$login = "Jose";
$password = 123456;

$stmt->bindParam(":LOGIN", $login);
$stmt->bindParam(":PASS", $password);

$stmt->execute();

echo "Inserido OK!";


?>