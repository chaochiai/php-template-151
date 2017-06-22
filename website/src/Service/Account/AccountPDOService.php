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
	
	public function EditAccount($firstname, $lastname, $username, $email, $gender, $weight, $height, $goal, $goalWeight, $goalCalories)
	{
		$firstname = htmlspecialchars($firstname);
		$lastname = htmlspecialchars($lastname);
		$username = htmlspecialchars($username);
		$email = htmlspecialchars($email);
		$gender = htmlspecialchars($gender);
		$weight = htmlspecialchars($weight);
		$height = htmlspecialchars($height);
		$goal = htmlspecialchars($goal);
		$goalWeight = htmlspecialchars($goalWeight);
		$goalCalories = htmlspecialchars($goalCalories);
			
		$usernameOld = $_SESSION["login"];	
				
		$stmt = $this->pdo->prepare("Update User SET firstname = ?, lastname = ?, username = ?, email = ?, gender = ?, currentWeight = ?, height = ?, Goal = ?, goalWeight = ?, caloriesGoalIntake = ? WHERE username = ?");
		$stmt->bindParam(1, $firstname);
		$stmt->bindParam(2, $lastname);
		$stmt->bindParam(3, $username);
		$stmt->bindParam(4, $email);
		$stmt->bindParam(5, $gender);
		$stmt->bindParam(6, $weight);
		$stmt->bindParam(7, $height);
		$stmt->bindParam(8, $goal);
		$stmt->bindParam(9, $goalWeight);
		$stmt->bindParam(10, $goalCalories);
		$stmt->bindParam(11, $usernameOld);
		$stmt->execute();
		if($stmt->rowCount() == 1){
			return true;
		}else{
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
		$data["id"] = $result->id;
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
	public function getUserData(){
		$data = $this->ShowPersonalInformation();
		$userId = $data["id"];
		$stmt = $this->pdo->prepare("SELECT * FROM Overview WHERE userId=? ORDER BY id DESC LIMIT 1");
		$stmt->bindValue(1, $userId);
		$stmt->execute();
		
		if($stmt->rowCount() == 1){
			$result = $stmt->fetch($this->pdo::FETCH_OBJ);
			$data["weight"] = $result->weight;
		}
		$data["Goal"] = $data["goal"];
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
			$email = $query->fetchColumn(2);
			return $email;
		} else {
			return null;
		}
	}
	public function deleteAccount(){
		$username = $_SESSION ["login"];
		$stmt = $this->pdo->prepare("SELECT * FROM User WHERE username=?");
		$stmt->execute ([$username]);
		
		if ($stmt->rowCount () == 1)
		{
			$userData = $stmt->fetch($this->pdo::FETCH_OBJ);
			$userId = $userData->id;
			
			try {
				$this->pdo->beginTransaction();
				
				$stmt = $this->pdo->prepare("DELETE FROM MealRecord WHERE userId=?");
				$stmt->execute ([$userId]);
	
				$stmt = $this->pdo->prepare("DELETE FROM Overview WHERE userId=?");
				$stmt->execute ([$userId]);
					
				$stmt = $this->pdo->prepare("DELETE FROM User WHERE id=?");
				$stmt->execute ([$userId]);
					
				$this->pdo->commit();
				return true;
			}
			catch (\PDOException $e)
			{
				$this->pdo->rollback();
				$_SESSION["errorDeleteAccount"] = "Internal error with the database transaction! Please try again!". " " .$e;
				return false;
			}
		}
	}
}