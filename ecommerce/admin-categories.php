<?php 

use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use \Hcode\Model\Product;

$app->get('/Admin/categories', function(){
    
    User::verifyLogin();
    
    $categories = Category::listall();
    
    $page = new PageAdmin();
    
    $page->setTpl("categories", [
        "categories"=>$categories
    ]);
    exit;
});
    
$app->get('/Admin/categories/create', function(){
    
    User::verifyLogin();
    
    $page = new PageAdmin();
    
    $page->setTpl("categories-create");
    exit;
});
        
$app->post('/Admin/categories/create', function(){
    
    User::verifyLogin();
    
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



$app->get('/Admin/categories/:idcategory/products', function($idcategory){
    
    User::verifyLogin();
    
    $category = new Category();
    $category->get((int)$idcategory);
    
    $page = new PageAdmin();
    
    $page->setTpl("categories-products", [
        "category"=>$category->getValues(),
        "productsRelated"=>$category->getProducts(),
        "productsNotRelated"=>$category->getProducts(false)
    ]);
    exit;
});

$app->get('/Admin/categories/:idcategory/products/:idproduct/add', function($idcategory, $idproduct){
    
    User::verifyLogin();
    
    $category = new Category();
    $category->get((int)$idcategory);
    
    $product = new Product();
    $product->get((int)$idproduct);
    
    $category->addProduct($product);
    
    header("Location: /Admin/categories/$idcategory/products");      
    exit;
});

$app->get('/Admin/categories/:idcategory/products/:idproduct/remove', function($idcategory, $idproduct){
    
    User::verifyLogin();
    
    $category = new Category();
    $category->get((int)$idcategory);
    
    $product = new Product();
    $product->get((int)$idproduct);
    
    $category->removeProduct($product);
    
    header("Location: /Admin/categories/$idcategory/products");       
    exit;
});
    


?>