<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Product;

$app->get("/Admin/products", function()
{
   
    User::verifyLogin();
    
    $products = Product::listAll();
    
    $page = new PageAdmin();
    
    $page->setTpl("products",
        array(
            "products"=>$products   
        ));
    
});

$app->get("/Admin/products/create", function()
{
    
    User::verifyLogin();
        
    $page = new PageAdmin();
    
    $page->setTpl("products-create");
    
});

$app->post("/Admin/products/create", function()
{
    User::verifyLogin();
    
    $product = new Product();    
    $product->setData($_POST);
    $product->save();
    
    header("Location: /Admin/products");
    exit;
    
});

$app->get("/Admin/products/:idproduct", function($idproduct)
{
    User::verifyLogin();
    
    $product = new Product();
    $product->get((int)$idproduct);
    
    $page = new PageAdmin();
    
    $page->setTpl("products-update",
        array("product"=>$product->getValues()));
    exit;
    
});

$app->post("/Admin/products/:idproduct", function($idproduct)
{
    User::verifyLogin();
    
    $product = new Product();
    $product->get((int)$idproduct);
    
    $product->setData($_POST);
    $product->save();
    
    $product->setPhoto($_FILES["file"]);
    
    
    header("Location: /Admin/products");
    exit;
    
});

?>