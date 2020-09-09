<?php 

use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use \Hcode\Model\Product;

$app->get('/Admin/categories', function(){
    
    User::verifyLogin();
    
    $search = (isset($_GET["search"]) ? $_GET["search"] : '');
    $page = (isset($_GET["page"]) ? (int) $_GET["page"] : 1);
    
    if($search != "")
    {
        $pagination = Category::getPageSearch($search, $page);
    }
    else
    {
        $pagination = Category::getPage($page);
    }
    
    $pages = [];
    
    for($x = 0; $x < $pagination["pages"]; $x++)
    {
        array_push($pages, [
            "href"=>"/Admin/categories?" . http_build_query(
                [
                    "page"=>$x+1,
                    "search"=>$search
                ]),
            "text"=>$x+1
        ]);
    }
    
    $page = new PageAdmin();
    
    $page->setTpl("categories", [
        "categories"=>$pagination["data"],
        "search"=>$search,
        "pages"=>$pages
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