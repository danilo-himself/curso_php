<?php

if (!is_dir("images2")) mkdir("images2");

foreach(scandir("images2") as $item)
{
	if(!in_array("$item", array(".","..")))
	{
		unlink("images2/".$item);
	}	
}

echo "OK";

?>