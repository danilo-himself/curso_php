<?php 

namespace Hcode;

class Model{
    
    private $values = [];
    
    public function __call($name, $args)
    {
        $method = substr($name, 0, 3);
        $fieldName = substr($name, 3, strlen($name));
        
        switch ($method)
        {
            case "get":
                return isset($this->values[$fieldName]) ? $this->values[$fieldName] : null;
                break;
            case "set":
                //echo $fieldName . " " . $args[0] . "<br>";
                $this->values[$fieldName] = $args[0];
                break;
            
        }
        /*
        var_dump($method, $fieldName);
        
        exit(); 
         */
        
    }
    
    public function setData($data = array())
    {
        foreach ($data as $key => $value)
        {
            //echo "key:" . $key . ". value: " . $value . "<br>";
            $this->{"set".$key}($value);
            
        }
    }
    
    public function getValues()
    {
        return $this->values;   
    }
    
}

?>