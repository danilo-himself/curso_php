<?php

function ola($texto = "mundo", $periodo = "Bom dia")
{
	return "Ola $texto! $periodo";
}

echo ola() . "<br>";
echo ola("Danilo") . "<br>";
echo ola("Marcos") . "<br>";


?>