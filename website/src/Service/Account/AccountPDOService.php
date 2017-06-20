<?php
namespace chaochiai\Service\Account;

class AccountPDOService implements AccountServiceInterface
{
	private $pdo;
	private $mailer;
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
		$username = $_SESSION['login'];
		$stmt = $this->pdo->prepare("SELECT * FROM User WHERE username=?");
		$stmt->bindValue(1, $username);
		$stmt->execute();
		$result = $stmt->fetch($this->pdo::FETCH_OBJ);
		$data["firstname"] = $result->firstname;
		$data["lastname"] = $result->lastname;
		$data["username"] = $result->username;
		$data["email"] = $result->email;
		$data["gender"] = $result->gender;
		$data["weight"] = $result->currentWeight;
		$data["height"] = $result->height;
		$data["goal"] = $result->Goal;
		$data["goalWeight"] = $result->goalWeight;
		$data["goalCalories"] = $result->caloriesGoalIntake;
		return $data;
	}

}