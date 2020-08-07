<?php

//$file = fopen("log.txt", "w+");

$file = fopen("log.txt", "a+");

fwrite($file, date("Y-m-d H:i:s"). "\r\n");

echo "Arquivo criado com sucesso!";

fclose($file);

?>