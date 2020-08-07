<?php

$conn = new PDO("mysql:dbname=dbphp7;host=localhost", "root", "");

$conn->beginTransaction();

$stmt = $conn->prepare("DELETE FROM tb_usuarios WHERE idusuario = :ID");

$id = 3;

$stmt->bindParam(":ID", $id);

$stmt->execute();

//$conn->rollback();
$conn->commit();

echo "DELETE OK!";


?>