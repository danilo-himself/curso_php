<?php

$pessoas = array();

array_push($pessoas, array(
	'nome'=>'Danilo',
	'idade'=>30)
	);

array_push($pessoas, array(
	'nome'=>'Joao',
	'idade'=>37)
	);
	
print_r($pessoas);	

print_r($pessoas[0]['nome']);

?>