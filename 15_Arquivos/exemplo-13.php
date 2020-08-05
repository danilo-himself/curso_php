<?php

//criando um cookie

$data = array(
	"empresa"=>"GOOGLE"
);

setcookie("NOME_DO_COOKIE", json_encode($data), time() + 3600);

echo "OK";

?>