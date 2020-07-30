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
	
echo json_encode($pessoas);

?>