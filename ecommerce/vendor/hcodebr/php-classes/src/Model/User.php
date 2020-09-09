<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;

class User extends Model{
    
    const SESSION = "User";
    const ERROR = "UserError";
    const ERROR_REGISTER = "ErrorRegister";
    const SECRET = "HcodePhp7_Secret";
    const SUCCESS = "UserSuccess";
    
    public static function getFromSession()
    {
        $user = new User();
        
        if(isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]["iduser"])
        {
            $user->setData($_SESSION[User::SESSION]);
        }
        
        return $user;
        
    }
    
    public static function checkLogin($inadmin = true)
    {
        if (
            !isset($_SESSION[User::SESSION])
            ||
            !($_SESSION[User::SESSION])
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
            )
        {
            //
            return false;
        }
        else 
        {
            if($inadmin === true && (bool) $_SESSION[User::SESSION]["inadmin"] === true)
            {
                return true;
            }
            else if($inadmin === false)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    
    
    public static function login($login, $password)
    {
        $sql = new Sql();
        
        $results = $sql->select("SELECT * FROM tb_users a
            INNER JOIN tb_persons b ON a.idperson = b.idperson  
            WHERE a.deslogin = :LOGIN", array(
            ":LOGIN"=>$login));
        
        if(count($results) === 0)
        {
            throw new \Exception("Usuario inexistente ou senha inválida", 1);
        }
        
        $data = $results[0];
        
        /*
        var_dump($data["despassword"]);
        echo "<br>";
        var_dump($password);
        exit;
        */
        
        if (password_verify($password, $data["despassword"]) === true)
        {
            
            $user = new User();
            
            //var_dump($data);
            
            $data["desperson"] = utf8_encode($data["desperson"]);
            
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
        //var_dump(User::checkLogin($inadmin));
        //exit;
        
        if (!User::checkLogin($inadmin))
         {
             if($inadmin)
             {
                 header("Location: /Admin/login");
             }
             else
             {
                 header("Location: /login");
             }
             
             exit;
         }                
    }
    
    public static function logout()
    {
        $_SESSION[User::SESSION] = NULL;   
    
    }
    
    public static function listAll()
    {
        $sql = new Sql();
        
        return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");
        
    }
    
    
    public function save()
    {
        $sql = new Sql();
        
        $results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
            ":desperson"=>utf8_decode($this->getdesperson()),
            ":deslogin"=>$this->getdeslogin(),
            ":despassword"=>User::getPasswordHash($this->getdespassword()),
            ":desemail"=>$this->getdesemail(),
            ":nrphone"=>$this->getnrphone(),
            ":inadmin"=>$this->getinadmin(),
        ));
        
        $this->setData($results[0]);
    }
    
    public function get($iduser)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser", array(
            ":iduser"=>$iduser
        ));
        
        $data = $results[0];
        $data["desperson"] = utf8_encode($data["desperson"]);
        
        $this->setData($results[0]);
    }
    
    public function update()
    {
        $sql = new Sql();
        
        $results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
            ":iduser"=>$this->getiduser(),
            ":desperson"=>utf8_decode($this->getdesperson()),
            ":deslogin"=>$this->getdeslogin(),
            ":despassword"=>User::getPasswordHash($this->getdespassword()),
            ":desemail"=>$this->getdesemail(),
            ":nrphone"=>$this->getnrphone(),
            ":inadmin"=>$this->getinadmin()
        ));
        
        $this->setData($results[0]);
    }
    
    public function delete()
    {
        
        $sql = new Sql();
        
        $results = $sql->select("CALL sp_users_delete(:iduser)", array(
            ":iduser"=>$this->getiduser()
        ));
    }
    
    public static function getForgot($email, $inadmin = true)
    {
        $sql = new Sql();
        
        $results = $sql->select("
            SELECT * FROM 
            tb_persons a 
            INNER JOIN tb_users b USING (idperson) 
            WHERE a.desemail = :email;
            ", array(
                ":email"=>$email            
        ));
        
        if (count($results) === 0)
        {
            throw new \Exception("Não foi possivel recuperar a senha", 1);   
        }
        else 
        {
            $data = $results[0];
            
            $results2 = $sql->select("CALL sp_userspasswordsrecoveries_create(:iduser, :desip)",array(
                ":iduser"=>$data["iduser"],
                ":desip"=>$_SERVER["REMOTE_ADDR"]
            ));
            
            if (count($results2) === 0 )
            {
                throw new \Exception("Não foi possivel recuperar a senha", 1);
            }
            else 
            {
                $dataRecovery = $results2[0];
                
                //$code = base64_encode(mcrypt_encrypt(MCRUPT_RIJNDAEL_128, User::SECRET, $dataRecovery["idrecovery"],MCRYPT_MODE_ECB));
                
                $code = base64_encode($dataRecovery["idrecovery"]);
                
                
                if($inadmin)
                {
                    $link = "http://www.hcodecommerce.com.br/Admin/forgot/reset?code=$code";
                }
                else 
                {
                    $link = "http://www.hcodecommerce.com.br/forgot/reset?code=$code";
                }
                
                
                $mailer = new Mailer($data["desemail"], $data["desperson"], "Redefinir Senha da Hcode Store", "forgot", array(
                    "name"=>$data["desperson"],
                    "link"=>$link
                ));
                
                $mailer->send();
                
                return $data;
            }
        }
    }
    
    public static function validForgotDecrypt($code)
    {
                
        //mcrypt_decrypt(MCRUPT_RIJNDAEL_128, User::SECRET, base64_decode($code),MCRYPT_MODE_ECB);
        
        $idrecovery = base64_decode($code);
        
        $sql = new Sql();
        
        $results = $sql->select("SELECT *
            FROM tb_userspasswordsrecoveries a
            INNER JOIN tb_users b USING (iduser)
            INNER JOIN tb_persons c using (idperson)
            WHERE 
            	a.idrecovery = :idrecovery
                AND 
                a.dtrecovery IS NULL
                AND 
                DATE_ADD(a.dtregister, INTERVAL 2 DAY) >= NOW();",
            array(":idrecovery" => $idrecovery));
        
        if (count($results) === 0)
        {
            throw new \Exception("Não foi possível recuperar a senha.",1);
            
        }
        else
        {
            
            return $results[0];
            
        }
    }
    
    public static function setForgotUsed($idrecovery)
    {
        $sql = new Sql();
        
        $sql->query("UPDATE tb_userspasswordsrecoveries SET dtrecovery = NOW() WHERE idrecovery= :idrecovery",
            array(":idrecovery" => $idrecovery));
                       
    }
    
    public function setPassword($password)
    {
        
        $sql = new Sql();
        
        $password = User::getPasswordHash($password);
        
        $sql->query("UPDATE tb_users SET despassword = :password WHERE iduser = :iduser",
            array(
                ":password" => $password,
                ":iduser" => $this->getiduser()
            ));
    
    }
    
    public static function setMsgError($msg)
    {
        $_SESSION[User::ERROR] = $msg;
    }
    
    public static function getMsgError()
    {
        $msg = (isset($_SESSION[User::ERROR])) ? $_SESSION[User::ERROR] : "";
        
        User::clearMSgError();
        
        return $msg;
    }
    
    public static function clearMsgError()
    {
        $_SESSION[User::ERROR] = "";
    }
    
    public static function setSuccess($msg)
    {
        $_SESSION[User::SUCCESS] = $msg;
    }
    
    public static function getMsgSuccess()
    {
        $msg = (isset($_SESSION[User::SUCCESS])) ? $_SESSION[User::SUCCESS] : "";
        
        User::clearMsgSuccess();
        
        return $msg;
    }
    
    public static function clearMsgSuccess()
    {
        $_SESSION[User::SUCCESS] = "";
    }
    
    public static function getPasswordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public static function setErrorRegister($msg)
    {
        $_SESSION[User::ERROR_REGISTER] = $msg;
    }
    
    public static function getErrorRegister()
    {
        $msg = (isset($_SESSION[User::ERROR_REGISTER]) && $_SESSION[User::ERROR_REGISTER]) ? $_SESSION[User::ERROR_REGISTER] : "";
        User::clearErrorRegister();
        return $msg;
    }
    
    public static function clearErrorRegister()
    {
        $_SESSION[User::ERROR_REGISTER] = NULL;
    }
    
    public static function checkLoginExist($login)
    {
        $sql = new Sql();
        
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :deslogin",
            [":deslogin"=>$login]);
        
        return (count($results) > 0);
    }
    
    public function getOrders()
    {
        $sql = new Sql();
        
        $results = $sql->select("SELECT * FROM tb_orders a
            INNER JOIN tb_ordersstatus b ON a.idstatus = b.idstatus
            INNER JOIN tb_carts c ON a.idcart = c.idcart
            INNER JOIN tb_users d ON d.iduser = a.iduser
            INNER JOIN tb_addresses e ON a.idaddress = e.idaddress
            INNER JOIN tb_persons f ON f.idperson = d.idperson
            WHERE d.iduser = :iduser",
            [":iduser"=>$this->getiduser()]);
        
        
        return $results;
        
        
        
    }
    
    public static function getPage($page = 1, $itemsPerPage = 2)
    {
        $start = ($page-1)*$itemsPerPage;
        $sql = new Sql();
        
        $results = $sql->select(
            "SELECT SQL_CALC_FOUND_ROWS *
            FROM tb_users a 
            INNER JOIN tb_persons b USING(idperson) 
            ORDER BY b.desperson
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
            FROM tb_users a
            INNER JOIN tb_persons b USING(idperson)
            WHERE b.desperson LIKE :search 
            OR b.desemail = :search
            OR a.deslogin LIKE :search
            ORDER BY b.desperson
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