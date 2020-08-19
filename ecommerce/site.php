<?php 

use \Hcode\Page;

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

$app->get('/categories/:idcategory', function($idcategory){
    
    User::verifyLogin();
    
    $category = new Category();
    $category->get((int)$idcategory);
    
    $page = new Page();
    
    $page->setTpl("category",
        array(
            "category"=>$category->getValues(),
            "products"=>[]
        ));
    
    exit;
    
});
    


?>