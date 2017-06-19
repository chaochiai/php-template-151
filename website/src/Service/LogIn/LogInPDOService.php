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
		$username = htmlspecialchars($username);
		$password = htmlspecialchars($password);
		$stmt = $this->pdo->prepare("SELECT * FROM User WHERE username=?");
		$stmt->bindValue(1, $username);
		$stmt->execute();
		
		if($stmt->rowCount() == 1){
			$result = $stmt->fetch($this->pdo::FETCH_OBJ);
			$hash = $result->password;
			if(password_verify($password, $hash)){
				$_SESSION["login"] = $username;
				return true;
			} else{
				return false;
			}
		} else{
			return false;
		}		
	}
	
}