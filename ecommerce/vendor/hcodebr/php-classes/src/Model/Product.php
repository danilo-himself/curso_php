<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;

class Product extends Model{
    
    public static function listAll()
    {
        $sql = new Sql();
        
        return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");
        
    }
    
    public static function checkList($list)
    {
        foreach($list as &$row)
        {
            $p = new Product();
            $p->setData($row);
            
            $row = $p->getValues();
        }
        
        return $list;
    }      
    
    public function save()
    {
        $sql = new Sql();
        
        $results = $sql->select("call sp_products_save(
                :idproduct, 
                :desproduct,
                :vlprice, 
                :vlwidth, 
                :vlheight, 
                :vllength, 
                :vlweight, 
                :desurl)",
            array(
                ":idproduct"=>$this->getidproduct(),
                ":desproduct"=>$this->getdesproduct(),
                ":vlprice"=>$this->getvlprice(),
                ":vlwidth"=>$this->getvlwidth(),
                ":vlheight"=>$this->getvlheight(),
                ":vllength"=>$this->getvllength(),
                ":vlweight"=>$this->getvlweight(),
                ":desurl"=>$this->getdesurl()
            ));
        
        $this->setData($results[0]);
    }
    
    public function get($idproduct)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct",
            array(":idproduct"=>$idproduct));
        
        $this->setData($results[0]);
        
    }
    
    public function delete()
    {
        $sql = new Sql();
        $sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct",
            array(":idproduct"=>$this->getidproduct()));
        
        
    }
    
    public function getValues()
    {
        
        $this->checkPhoto();
        $values = parent::getValues();                      
        return $values;
    }
    
    public function checkPhoto()
    {
        
        $file = $_SERVER['DOCUMENT_ROOT'] .
        DIRECTORY_SEPARATOR . "res" .
        DIRECTORY_SEPARATOR . "site" .
        DIRECTORY_SEPARATOR . "img" .
        DIRECTORY_SEPARATOR . "products" .
        DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg";
        
        if(file_exists($file))
        {                      
            $url =  "/res/site/img/products/" . $this->getidproduct() . ".jpg";            
        }
        else
        {
            $url =  "/res/site/img/products/product.jpg";            
        }
        
        return $this->setdesphoto($url);
        
    }
    
    public function setPhoto($file)
    {
        $extension = explode(".", $file["name"]);
        $extension = strtolower ( end($extension));
        
        switch ($extension)
        {
            case "jpg":
            case "jpg":
                $image = imagecreatefromjpeg($file["tmp_name"]);
                break;
            
            case "gif":
                $image = imagecreatefromgif($file["tmp_name"]);
                break;
                               
            case "png":
                $image = imagecreatefrompng($file["tmp_name"]);
                break;                              
        }
        
        $dist = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR .
            "res" . DIRECTORY_SEPARATOR .
            "site" . DIRECTORY_SEPARATOR .
            "img" . DIRECTORY_SEPARATOR .
            "products" . DIRECTORY_SEPARATOR .
            $this->getidproduct() . ".jpg";
        
        imagejpeg($image,$dist);
        imagedestroy($image);
        
        $this->checkPhoto();
    }
    
    public function getFromUrl($desurl)
    {
        $sql = new Sql();
        
        $rows = $sql->select("SELECT * FROM tb_products 
            WHERE desurl = :desurl", 
            [
                ":desurl"=>$desurl
                
            ]);
                
        $this->setData($rows[0]);
    }
    
    public function getCategories()
    {
        $sql = new Sql();
        
        return $sql->select("SELECT a.* FROM tb_categories a
                INNER JOIN tb_productscategories b ON
                b.idcategory = a.idcategory
                WHERE b.idproduct = :idproduct",
            [
                ":idproduct"=>$this->getidproduct()
            ]);
        
    }
    
    public static function getPage($page = 1, $itemsPerPage = 2)
    {
        $start = ($page-1)*$itemsPerPage;
        $sql = new Sql();
        
        $results = $sql->select(
            "SELECT SQL_CALC_FOUND_ROWS *
            FROM tb_products
            ORDER BY desproduct
            LIMIT $start,$itemsPerPage"
            );
        
        $resultsTotal = $sql->select("SELECT found_rows() as nrTotal");
        
        return [
            "data"=>$results,
            "total"=>(int)$resultsTotal[0]["nrTotal"],
            "pages"=>ceil($resultsTotal[0]["nrTotal"]/$itemsPerPage)
        ];
    }
    
    
    public static function getPageSearch($search, $page = 1, $itemsPerPage = 2)
    {
        $start = ($page-1)*$itemsPerPage;
        $sql = new Sql();
        
        
        $results = $sql->select(
            "SELECT SQL_CALC_FOUND_ROWS *
            FROM tb_products             
            WHERE desproduct LIKE :search
            ORDER BY desproduct
            LIMIT $start,$itemsPerPage",
            [":search"=>"%" . $search . "%"]
            );
        
        $resultsTotal = $sql->select("SELECT found_rows() as nrTotal");
        
        return [
            "data"=>$results,
            "total"=>(int)$resultsTotal[0]["nrTotal"],
            "pages"=>ceil($resultsTotal[0]["nrTotal"]/$itemsPerPage)
        ];
    }
    
}

?>