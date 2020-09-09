<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Product;

$app->get("/Admin/products", function()
{
   
    User::verifyLogin();
    
    $search = (isset($_GET["search"]) ? $_GET["search"] : '');
    $page = (isset($_GET["page"]) ? (int) $_GET["page"] : 1);
    
    if($search != "")
    {
        $pagination = Product::getPageSearch($search, $page);
    }
    else
    {
        $pagination = Product::getPage($page);
    }
    
    
    
    $pages = [];
    
    for($x = 0; $x < $pagination["pages"]; $x++)
    {
        array_push($pages, [
            "href"=>"/Admin/products?" . http_build_query(
                [
                    "page"=>$x+1,
                    "search"=>$search
                ]),
            "text"=>$x+1
        ]);
    }
       
    
    $page = new PageAdmin();
    
    $page->setTpl("products",
        array(
            "products"=>$pagination["data"],
            "search"=>$search,
            "pages"=>$pages
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

$app->get("/Admin/products/:idproduct/delete", function($idproduct)
{
    User::verifyLogin();
    
    $product = new Product();
    $product->get((int)$idproduct);
    
    $product->delete();
    
    header("Location: /Admin/products");
    exit;
    
});

?>