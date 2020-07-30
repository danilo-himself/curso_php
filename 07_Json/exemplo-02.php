<?php

	$json = '[{"nome":"Danilo","idade":30},{"nome":"Joao","idade":37}]';
	
	$data = json_decode($json,true);
	
	var_dump($data);

?>