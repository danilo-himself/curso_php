<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;

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

?>