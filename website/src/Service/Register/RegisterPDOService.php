<?php
namespace chaochiai\Service\Register;

class RegisterPDOService implements RegisterServiceInterface
{
	private $pdo;
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function Register($firstname, $lastname, $username, $email, $password, $gender, $weight, $height, $goal, $goalWeight, $goalCalories)
	{
		$firstname = htmlspecialchars($firstname);
		$lastname = htmlspecialchars($lastname);
		$username = htmlspecialchars($username);
		$email = htmlspecialchars($email);
		$password = htmlspecialchars($password);
		$gender = htmlspecialchars($gender);
		$weight = htmlspecialchars($weight);
		$height = htmlspecialchars($height);
		$goal = htmlspecialchars($goal);
		$goalWeight = htmlspecialchars($goalWeight);
		$goalCalories = htmlspecialchars($goalCalories);
		//validation user already exist
		$stmt = $this->pdo->prepare("SELECT * FROM User WHERE email=?");
		$stmt->bindValue(1, $email);
		$stmt->execute();
			
		if($stmt->rowCount() == 1){
			return false;
		} else{	
			
			$passwordSalted = password_hash($password, PASSWORD_DEFAULT);
			
			$stmt = $this->pdo->prepare("INSERT INTO User (firstname, lastname, username, email, password, gender, currentWeight, height, Goal, goalWeight, caloriesGoalIntake) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
			$stmt->bindParam(1, $firstname);
			$stmt->bindParam(2, $lastname);
			$stmt->bindParam(3, $username);
			$stmt->bindParam(4, $email);
			$stmt->bindParam(5, $passwordSalted);
			$stmt->bindParam(6, $gender);
			$stmt->bindParam(7, $weight);
			$stmt->bindParam(8, $height);
			$stmt->bindParam(9, $goal);
			$stmt->bindParam(10, $goalWeight);
			$stmt->bindParam(11, $goalCalories);
			$stmt->execute();
			return true;
		}

	}

}