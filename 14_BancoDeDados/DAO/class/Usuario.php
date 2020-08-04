<?php

class Usuario
{
	private $idusuaio;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;
	
	public function getIdusuario()
	{
		return $this->idusuaio;
	}
	
	public function setIdusuario($value)
	{
		$this->idusuaio = $value;
	}
	
	public function getDeslogin()
	{
		return $this->deslogin;
	}
	
	public function setDeslogin($value)
	{
		$this->deslogin = $value;
	}
	
	public function getDessenha()
	{
		return $this->dessenha;
	}
	
	public function setDessenha($value)
	{
		$this->dessenha = $value;
	}
	
	public function getDtcadastro()
	{
		return $this->dtcadastro;
	}
	
	public function setDtcadastro($value)
	{
		$this->dtcadastro = $value;
	}
	
	public function loadById($id)
	{
		$sql = new Sql();
		
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));
		
		if(count($results) > 0)
		{
			$row = $results[0];
			
			$this->setIdusuario($row['idusuario']);
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			$this->setDtcadastro($row['dtcadastro']);
			
		}
	}
	
	public static function getList()
	{
		$sql = new Sql;
		
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
	}
	
	public static function search($login)
	{
		$sql = new Sql;
		
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin like :SERACH ORDER BY deslogin", array(":SERACH"=>"%".$login."%"));
	}
	
	public function login($login, $senha)
	{
		$sql = new Sql();
		
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :SENHA", 
			array(
				":LOGIN"=>$login, 
				":SENHA"=>$senha
				)
			);
		
		if(count($results) > 0)
		{
			$row = $results[0];
			
			$this->setIdusuario($row['idusuario']);
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			$this->setDtcadastro($row['dtcadastro']);
			
		}
	}
	
	public function __toString()
	{
		return json_encode(array(
			"idusuario"=>$this->getIdusuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtcadastro()
		));
	}
	
}

?>