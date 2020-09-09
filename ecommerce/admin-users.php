<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;


$app->get('/Admin/users', function() {
    
    User::verifyLogin();
    
    $search = (isset($_GET["search"]) ? $_GET["search"] : '');    
    $page = (isset($_GET["page"]) ? (int) $_GET["page"] : 1);
    
    if($search != "")
    {
        $pagination = User::getPageSearch($search, $page);
    }
    else 
    {
        $pagination = User::getPage($page);
    }
    
    
    
    $pages = [];
    
    for($x = 0; $x < $pagination["pages"]; $x++)
    {
        array_push($pages, [
            "href"=>"/Admin/users?" . http_build_query(
                [
                    "page"=>$x+1, 
                    "search"=>$search
                ]),
                "text"=>$x+1
            ]);
    }
        
    $page = new PageAdmin();
    
    $page->setTpl("users", array(
        "users"=>$pagination["data"],
        "search"=>$search,
        "pages"=>$pages
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