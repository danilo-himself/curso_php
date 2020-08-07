<?php

//cURL

$cep = "01310100";
$link = "https://viacep.com.br/ws/".$cep."/json/";

//echo $link;

$ch = curl_init($link);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$response = curl_exec($ch);

//var_dump($response);

curl_close($ch);

$data = json_decode($response, true);
print_r($data);




?>