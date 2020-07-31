<?php

	//session_start();
	
	require_once("config.php");
	
	session_unset();
	
	echo $_SESSION['nome'];
	
	session_destroy();

?>