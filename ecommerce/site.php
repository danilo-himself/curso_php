<?php 

use \Hcode\Page;
use \Hcode\Model\Category;
use \Hcode\Model\Product;
use \Hcode\Model\User;
use \Hcode\Model\Cart;
use \Hcode\Model\Address;

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

$app->get('/cart', function(){
          
    $cart = Cart::getFromSession();
    
    $page = new Page();
        
    $page->setTpl("cart",
        array(
            "cart"=>$cart->getValues(),
            "products"=>$cart->getProducts(),
            "error"=>Cart::getMsgError()
        ));
    
    exit;
    
});

$app->get('/cart/:idproduct/add', function($idproduct){
    
    $cart = Cart::getFromSession();
    
    $product = new Product();
    $product->get((int)$idproduct);
    
    $qtd = (isset($_GET["qtd"])) ? (int)$_GET["qtd"] : 1;
    
    for($i = 0; $i< $qtd; $i++)
    {
        $cart->addProduct($product);
    }
        
    header("Location: /cart");
    exit;
    
});
    
$app->get('/cart/:idproduct/minus', function($idproduct){
    
    $cart = Cart::getFromSession();
    
    $product = new Product();
    $product->get((int)$idproduct);
           
    $cart->removeProduct($product);
        
    header("Location: /cart");
    exit;
    
});

$app->get('/cart/:idproduct/remove', function($idproduct){
    
    $cart = Cart::getFromSession();
    
    $product = new Product();
    $product->get((int)$idproduct);
    
    $cart->removeProduct($product, true);
    
    header("Location: /cart");
    exit;
    
});
    

$app->post('/cart/freight', function()
{
    $cart = Cart::getFromSession();
    
    $cart->setFreight($_POST['zipcode']);
    
    header("Location: /cart");
    exit;
});

$app->get("/checkout", function(){
    
    User::verifyLogin(false);
    
    $cart = Cart::getFromSession();
    
    $address = new Address();
    
    $page = new Page();
    
    $page->setTpl("checkout",[
        "cart"=>$cart->getValues(),
        "address"=>$address->getValues()
    ]);
    
});

$app->get("/login", function(){
    
    
    $page = new Page();
    
    $page->setTpl("login",[
        "error"=>User::getMsgError(),
        "errorRegister"=>User::getErrorRegister(),
        "registerValues"=>isset($_SESSION["registerValues"]) ? 
            $_SESSION["registerValues"] 
            : ["name" => "", "email" => "", "phone" => ""] 
    ]);
    
});

$app->post("/login", function(){
    
    try
    {
        User::login($_POST['login'],$_POST['password']);
    }
    catch(Exception $e)
    {
        User::setMsgError($e->getMessage());
    }
    
    
    
    header("Location: /checkout");
    exit;
    
});

$app->get("/logout", function(){
    
    User::logout();     
    
    header("Location: /");
    exit;
    
});

$app->post("/register", function()
{
    
    $_SESSION["registerValues"] = $_POST;
    
    if(!isset($_POST["name"]) || $_POST["name"] == ""){
        User::setErrorRegister("Preencha o seu nome");
        header("Location: /login");
        exit;
    }
    
    if(!isset($_POST["email"]) || $_POST["email"] == ""){
        User::setErrorRegister("Preencha o seu email");
        header("Location: /login");
        exit;
    }
    
    if(!isset($_POST["password"]) || $_POST["password"] == ""){
        User::setErrorRegister("Preencha a sua senha");
        header("Location: /login");
        exit;
    }
    
    if(User::checkLoginExist($_POST["email"]) === true)
    {        
        User::setErrorRegister("Email ja esta cadastrado");
                
        //User::setErrorRegister("TESTE ERRO");
        //var_dump(User::getErrorRegister());
        //exit;
        
        header("Location: /login");
        exit;
    }
    
    $user = new User();
    
    $user->setData([
       "inadmin"=>0,
        "deslogin"=>$_POST["email"],
        "desperson"=>$_POST["name"],
        "desemail"=>$_POST["email"],
        "despassword"=>$_POST["password"],
        "nrphone"=>$_POST["phone"]
        
    ]);
    
    $user->save();
    
    User::login($_POST["email"], $_POST["password"]);
    
    header("Location: /checkout");
    exit;
    
    
});

$app->get('/forgot', function()
{
    $page = new Page([
        "Header"=>false,
        "footer"=>false
    ]);
    
    $page->setTpl("forgot");
});


$app->post('/forgot', function()
{
    $user = User::getForgot($_POST["email"], false);
    
    header("Location: /forgot/sent");
    exit;
});

$app->get('/forgot/sent', function()
{
    $page = new Page([
        "Header"=>false,
        "footer"=>false
    ]);
    
    $page->setTpl("forgot-sent");
    exit;
});

$app->get('/forgot/reset', function()
{
    
    $user = User::validForgotDecrypt($_GET["code"]);
    
    
    $page = new Page([
        "Header"=>false,
        "footer"=>false
    ]);
    
    $page->setTpl("forgot-reset", array(
        "name" => $user["desperson"] ,
        "code" => $_GET["code"]
    ));
    exit;
});


$app->post('/forgot/reset', function()
{
    
    $forgot = User::validForgotDecrypt($_POST["code"]);
    
    User::setForgotUsed($forgot["idrecovery"]);
    
    $user = new User();
    
    $user->get((int)$forgot["iduser"]);
    
    $user->setPassword($_POST["password"]);
    
    $page = new Page([
        "Header"=>false,
        "footer"=>false
    ]);
    
    $page->setTpl("forgot-reset-success");
    exit;
    
});

$app->get("/profile", function(){
    
    User::verifyLogin(false);
    
    $user = User::getFromSession();
    
    $page = new Page();
    
    $page->setTpl("profile",
        [
           "user"=>$user->getValues(),
            "profileMsg"=>User::getMsgSuccess(),
            "profileError"=>User::getMsgError()
        ]);
    
});

$app->post("/profile", function(){
   
    User::verifyLogin(false);
    
    /*
    var_dump($_POST);
    exit;*/
    
    if(!isset($_POST["desperson"]) || $_POST["desperson"] === ""){
        User::setError("Preencha o seu nome");
        header("Location: /profile");
        exit;
    }
    
    if(!isset($_POST["desemail"]) || $_POST["desemail"] === ""){
        User::setError("Preencha o seu email");
        header("Location: /profile");
        exit;
    }
    
    $user = User::getFromSession();
    
    if($_POST["desemail"] != $user->getdesemail())
    {
        if (User::checkLoginExists($_POST["desemail"])) {
            User::setError("Email j� cadastrado");
            header("Location: /profile");
            exit;
        }
    }
    
    
    
    $_POST["inadmin"] = $user->getinadmin();
    // $_POST["despassword"] = $user->getdespassword();
    $_POST["deslogin"] = $user->getdeslogin();
    
    $user->setData($_POST);
    
    $user->update();
    
    User::setSuccess("Dados alterados com sucesso!");
    
    header("Location: /profile");
    exit;
    
});


?>