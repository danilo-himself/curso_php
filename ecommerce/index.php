<?php 

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim; 
use Hcode\Page;
use Hcode\PageAdmin;
use Hcode\Model\User;

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
    
      
    User::verifyLogin();
    
	$page = new PageAdmin();
	$page->setTpl("index");

});

$app->get('/Admin/login', function() {
    
    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);
    $page->setTpl("login");
    
});

$app->post('/Admin/login', function() {
    
    //var_dump($_POST);
    
   User::login($_POST["login"], $_POST["password"]);     
   
   header("Location: /Admin");
   
   exit();
    
});

$app->get('/Admin/logout', function() {
    
    User::logout();
    
    header("Location: /Admin/login");
    
    exit();
    
});
    
    

$app->run();

 ?>