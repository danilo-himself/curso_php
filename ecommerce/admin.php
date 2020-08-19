<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;

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

$app->get('/Admin/forgot/reset', function()
{
    
    $user = User::validForgotDecrypt($_GET["code"]);
    
    
    $page = new PageAdmin([
        "Header"=>false,
        "footer"=>false
    ]);
    
    $page->setTpl("forgot-reset", array(
        "name" => $user["desperson"] ,
        "code" => $_GET["code"]
    ));
    exit;
});


$app->post('/Admin/forgot/reset', function()
{
    
    $forgot = User::validForgotDecrypt($_POST["code"]);
    
    User::setForgotUsed($forgot["idrecovery"]);
    
    $user = new User();
    
    $user->get((int)$forgot["iduser"]);
    
    $user->setPassword($_POST["password"]);
    
    $page = new PageAdmin([
        "Header"=>false,
        "footer"=>false
    ]);
    
    $page->setTpl("forgot-reset-success");
    exit;
    
});



?>