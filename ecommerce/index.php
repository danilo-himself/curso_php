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

$app->get('/Admin/users', function() {
    
    User::verifyLogin();
    
    $users = User::listAll();
    
    $page = new PageAdmin();
    
    $page->setTpl("users", array(
        "users"=>$users
    ));
    
});

$app->get('/Admin/users/create', function() {
    
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("users-create");
    
});

$app->get('/Admin/users/:iduser/delete', function($iduser) {
    
    User::verifyLogin();
    
    $user = new User();
    $user->get((int)$iduser);
    
    $user->delete();
    
    header("Location: /Admin/users");
    exit;
    
});

$app->get('/Admin/users/:iduser', function($iduser) {
    
    User::verifyLogin();
    
    $user = new User();
    $user->get((int)$iduser);
    
    $page = new PageAdmin();
    $page->setTpl("users-update", array(
     "user"=>$user->getValues()   
    ));
    
});
    

$app->post('/Admin/users/create', function() {
    
    
    User::verifyLogin();
    
    //var_dump($_POST);
    
    $user = new User();
    
    $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
    
    $user->setData($_POST);
    
    //var_dump($user);
    
    $user->save();
    
    header("Location: /Admin/users");
    exit;
    
});

$app->post('/Admin/users/:iduser', function($iduser) {
    
    User::verifyLogin();
    
    $user = new User();
    
    $user->get((int)$iduser);
    
    $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
    
    $user->setData($_POST);
    
    $user->update();
    
    header("Location: \Admin\users");
    exit;
    
});

$app->get('/Admin/forgot', function()
{
    $page = new PageAdmin([
        "Header"=>false,
        "footer"=>false    
        ]);
    
    $page->setTpl("forgot");
});
    

$app->post('/Admin/forgot', function()
{      
    $user = User::getForgot($_POST["email"]);
    
    header("Location: /Admin/forgot/sent");
    exit;
});

$app->get('/Admin/forgot/sent', function()
{
    $page = new PageAdmin([
        "Header"=>false,
        "footer"=>false
    ]);
    
    $page->setTpl("forgot-sent");
    exit;
});



$app->run();

 ?>