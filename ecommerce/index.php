<?php 

require_once("vendor/autoload.php");

use \Slim\Slim; 
use Hcode\Page;
use Hcode\PageAdmin;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	//teste conexão
	/*
	$sql = new Hcode\DB\Sql();	
	$results = $sql->select("SELECT * FROM tb_users");	
	echo json_encode($results);
	*/
	//echo "OK";
	
	$page = new Page();
	$page->setTpl("index");

});

$app->get('/Admin', function() {
    
	$page = new PageAdmin();
	$page->setTpl("index");

});

$app->run();

 ?>