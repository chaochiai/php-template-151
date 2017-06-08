<?php
namespace chaochiai\Service\Account;

class AccountPDOService implements AccountServiceInterface
{
	private $pdo;
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function EditAccount()
	{
		$username = $_SESSION['username'];
		$stmt = $this->pdo->prepare("SELECT * FROM User WHERE username=? AND password=?");
		$stmt->bindValue(1, $username);
		$stmt->bindValue(2, $password);
		$stmt->execute();
			
		if($stmt->rowCount() == 1){
			$_SESSION["login"] = $username;
			return true;
		} else{
			return false;
		}

	}
	public function ShowPersonalInformation()
	{
	
	}

}