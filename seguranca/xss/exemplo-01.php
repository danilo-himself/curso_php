<form method="post">

	<input type="text" name="busca">
	<button type="submit">Enviar</button>

</form>


<?php

if(isset($_POST['busca']))
{
	//echo strip_tags($_POST['busca']); //remove todas as tags
	//echo strip_tags($_POST['busca'], "<strong>"); //remove todas as tags menos as passadas no segundo param
	echo htmlentities($_POST['busca']);
}

?>