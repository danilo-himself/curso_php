<?php 

use \Hcode\Page;
use \Hcode\Model\Category;
use \Hcode\Model\Product;
//use \Hcode\Model\User;

$app->get('/', function() {
    
    //teste conexão
    /*
     $sql = new Hcode\DB\Sql();
     $results = $sql->select("SELECT * FROM tb_users");
     echo json_encode($results);
     */
    
    $products = Product::listAll();
    //echo "OK";
    
    $page = new Page();
    $page->setTpl("index", [
        "products"=>Product::checkList($products)]);
    
});

$app->get('/categories/:idcategory', function($idcategory){
    
    $page = (isset($_GET["page"])) ? (int)$_GET["page"] : 1;
       
    $category = new Category();
    $category->get((int)$idcategory);
    
    $pagination = $category->getProductsPage($page);
    
    $pages = [];
    
    for($i=1;$i<=$pagination["pages"];$i++)
    {
        array_push($pages, [
            "link"=>"/categories/".$category->getidcategory()."?page=".$i,
            "page"=>$i
        ]);
    }
    
    $page = new Page();
        
    $page->setTpl("category",
        array(
            "category"=>$category->getValues(),
            "products"=>$pagination["data"] ,
            "pages"=>$pages
        ));
    
    exit;
    
});

$app->get('/products/:desurl', function($desurl){
 
    $product = new Product();
    
    $product->getFromUrl($desurl);
        

    $page = new Page();
    
    $page->setTpl("product-detail",
        array(            
            "product"=>$product->getValues(),
            "categories"=>$product->getCategories()
        ));
    
    exit;
    
});
    


?>