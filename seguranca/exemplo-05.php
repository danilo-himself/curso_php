<?php

var_dump(PHP_VERSION);

//mcrypt_encrypt só funciona ate a versão 7.1 do php

$data = [
	"nome"=>"Danilo"
];

define('SECRET', pack('a16', 'senha'));

$mcrypt = mcrypt_encrypt(
	MCRYPT_RIJNDAEL_128,
	SECRET,
	json_encode($data),
	MCRYPT_MODE_ECB
);

$final = base64_encode($mcrypt);
//var_dump(base64_encode($mcrypt));

$string = mcrypt_decrypt(
	MCRYPT_RIJNDAEL_128,
	SECRET,
	base64_decode($final),
	MCRYPT_MODE_ECB
);

var_dump(json_decode($string));



?>