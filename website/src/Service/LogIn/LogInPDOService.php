<?php
namespace chaochiai\Service\LogIn;

class LogInPDOService implements LogInServiceInterface
{
	private $pdo;
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function Authentication($username, $password)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM User WHERE email=? AND password=?");
		$stmt->bindValue(1, $username);
		$stmt->bindValue(2, $password);
		$stmt->execute();
			
		if($stmt->rowCount() == 1){
			$_SESSION["email"] = $username;
			return true;
		} else{
			return false;
		}
		
	}
	
}