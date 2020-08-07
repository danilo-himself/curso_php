<?php

//download de arquivo

$link = "https://www.google.com.br/logos/doodles/2020/wear-a-mask-save-lives-copy-6753651837108810-law.gif";

$content = file_get_contents($link);

//var_dump($content);

$parse = parse_url($link);

//var_dump($parse);

$basename = basename($parse["path"]);

$file = fopen($basename, "w+");

fwrite($file, $content);

fclose($file);



?>

<img src="<?=$basename?>">
