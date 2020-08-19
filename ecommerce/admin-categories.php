<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;

$app->get('/Admin/categories', function(){
    
    $categories = Category::listall();
    
    $page = new PageAdmin();
    
    $page->setTpl("categories", [
        "categories"=>$categories
    ]);
    exit;
});
    
$app->get('/Admin/categories/create', function(){
    
    
    $page = new PageAdmin();
    
    $page->setTpl("categories-create");
    exit;
});
        
$app->post('/Admin/categories/create', function(){
    
    $category = new Category();
    $category->setData($_POST);
    $category->save();
    
    header('Location: /Admin/categories');
    exit;
});
            
$app->get('/Admin/categories/:idcategory/delete', function($idcategory){
    
    User::verifyLogin();
    
    $category = new Category();
    $category->get((int)$idcategory);
    
    $category->delete();
    
    header("Location: /Admin/categories");
    exit;
    
});
    
    
$app->get('/Admin/categories/:idcategory', function($idcategory){
    
    User::verifyLogin();
    
    $category = new Category();
    $category->get((int)$idcategory);
    
    $page = new PageAdmin();
    
    $page->setTpl("categories-update",
        array("category"=>$category->getValues()));
    
    exit;
    
});
        
$app->post('/Admin/categories/:idcategory', function($idcategory){
    
    User::verifyLogin();
    
    $category = new Category();
    $category->get((int)$idcategory);
    
    $category->setData($_POST);
    
    $category->save();
    header("Location: /Admin/categories");
    
    exit;
    
});

?>