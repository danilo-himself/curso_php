<?php 

namespace HCode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model{
    
    const SESSION = "User";
    
    public static function login($login, $password)
    {
        $sql = new Sql();
        
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login));
        
        if(count($results) === 0)
        {
            throw new \Exception("Usuario inexistente ou senha inválida", 1);
        }
        
        $data = $results[0];
        
        if (password_verify($password, $data["despassword"]) === true)
        {
            
            $user = new User();
            
            //var_dump($data);
            
            $user->setData($data);
            //var_dump($user);
            
            //var_dump($user->getValues());            
            
            $_SESSION[User::SESSION] = $user->getValues();
            
            return $user;
            
            
            /*
            $user->setiduser($data["iduser"]);            
            var_dump($user);
            exit();            
             */
        }
        else 
        {
            throw new \Exception("Usuario inexistente ou senha inválida", 1);
        
        }
    }
    
    public static function verifyLogin($inadmin = true)
    {
        //var_dump($_SESSION);
        
         if (
             !isset($_SESSION[User::SESSION]) 
             || 
             !($_SESSION[User::SESSION])
             ||
             !(int)$_SESSION[User::SESSION]["iduser"] > 0
             ||
             (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
             )
         {
             header("Location: /Admin/login");
             exit;
         }                
    }
    
    public static function logout()
    {
        $_SESSION[User::SESSION] = NULL;   
    
    }
    
}

?>