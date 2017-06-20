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
	public function getUrl($email){
		$timePoint = time();
		$query = $this->pdo->prepare("SELECT * FROM User WHERE email = ?");
		$query->execute([$email]);
		if ($query->rowCount() > 0){
			$userId = $query->fetchColumn(0);
			
			$key = sprintf('%d%d', $userId, $timePoint);
			$url = sprintf ("%s://%s/%s?key=%s", isset($_SERVER ['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['HTTP_HOST'], "resetpassword", $key);
			$data["url"] = $url;
			$data["timePoint"] = $timePoint;
			$data["userId"] = $userId;
			
			return $data;
		}else{
			return null;
		}
	}
	public function setPoint($timePoint, $userId){
		$query = $this->pdo->prepare("UPDATE User SET resetPoint = ? WHERE id = ?");
		$query->execute([$timePoint, $userId]);
		if ($query->rowCount() == 1){
			return true;
		}else{
			return false;
		}
	}
	public function resetPassword($key, $newPassword){
		$email = $this->getEmailByResetKey($key);
		if($email != null){
			$passwordSalted = password_hash($newPassword, PASSWORD_DEFAULT);
			$stmt = $this->pdo->prepare("UPDATE User SET password = ? WHERE email = ?");
			$stmt->bindParam(1, $passwordSalted);
			$stmt->bindParam(2, $email);
			$stmt->execute();
		}
		if ($stmt->rowCount() > 0){
			return true;
		} else {
			return false;
		}
	}
	public function getEmailByResetKey($key)
	{
		$query = $this->pdo->prepare("SELECT * from User WHERE Concat(id, resetPoint) = ?");
		$query->execute([$key]);
	
		if ($query->rowCount () > 0){
			$email = $query->fetchColumn(3);
			return $email;
		} else {
			return null;
		}
	}
}