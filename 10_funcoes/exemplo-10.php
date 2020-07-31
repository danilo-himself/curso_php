<?php

//exemplo de funcao anonima

function teste($callback)
{
	//processo lento
	
	$callback();
}	

teste(function() {
	echo "Terminou";
});

?>