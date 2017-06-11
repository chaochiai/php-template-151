<?php
namespace chaochiai\Service\Diet;

class DietPDOService implements DietServiceInterface
{
	private $pdo;
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	public function getUserId()
	{
		$username = $_SESSION["login"];
		$stmt = $this->pdo->prepare("SELECT id FROM User WHERE username=?");
		$stmt->bindValue(1, $username);
		$stmt->execute();
		$result = $stmt->fetch($this->pdo::FETCH_OBJ);
		
		return $id = $result->id;
	}
	public function WeightLeft()
	{
		$username = $_SESSION["login"];
		$stmt = $this->pdo->prepare("SELECT id, currentWeight, goalWeight, Goal  FROM User WHERE username=?");
		$stmt->bindValue(1, $username);
		$stmt->execute();
		
		$result = $stmt->fetch($this->pdo::FETCH_OBJ);
		$id = $result->id;
		$currentWeight = $result->currentWeight;
		$goalWeight = $result->goalWeight;
		$goal = $result->Goal;
		
		$stmt2 = $this->pdo->prepare("SELECT * FROM Weight WHERE userId=?");
		$stmt2->bindValue(1, $id);
		$stmt2->execute();
		
		if($stmt2->rowCount() == 1){
			$result2 = $stmt2->fetch($this->pdo::FETCH_OBJ);
			$weight = $result2->weight;
			switch($goal)
			{
				case 'Lose Weight':
					$weightLeft = $weight - $goalWeight;
					break;
				case 'Maintain Weight':
					$weightLeft = null;
					break;
				case 'Gain Weight':
					$weightLeft = $goalWeight - $weight;
					break;
			}
			return $weightLeft;
		} else{
			switch($goal)
			{
				case 'Lose Weight':
					$weightLeft = $currentWeight - $goalWeight;
					break;
				case 'Maintain Weight':
					$weightLeft = null;
					break;
				case 'Gain Weight':
					$weightLeft = $goalWeight - $currentWeight;
					break;
			}
			return $weightLeft;
		}
	}
	public function recordMeal($mealType, $foodName, $calories){
		//validation meal already exist
		$stmt = $this->pdo->prepare("SELECT * FROM Meal WHERE name=? AND calories=?");
		$stmt->bindValue(1, $foodName);
		$stmt->bindValue(2, $calories);
		$stmt->execute();
		$mealId;
		
		if($stmt->rowCount() == 1){
			$result = $stmt->fetch($this->pdo::FETCH_OBJ);
			$mealId = $result->id;
		} else{
			$stmt2 = $this->pdo->prepare("INSERT INTO Meal (Name, Calories) VALUES (?,?)");
			$stmt2->bindParam(1, $foodName);
			$stmt2->bindParam(2, $calories);
			$stmt2->execute();
			$mealId = $this->pdo->lastInsertId();		
		}
		$userId = $this->getUserId();
		$date = date("Y-m-d H:i:s"); 
		$stmt3 = $this->pdo->prepare("INSERT INTO MealRecord (userId, mealId, mealType, Date) VALUES (?,?,?,?)");
		$stmt3->bindParam(1, $userId);
		$stmt3->bindParam(2, $mealId);
		$stmt3->bindParam(3, $mealType);
		$stmt3->bindParam(4, $date);
		$stmt3->execute();
		if(empty($this->pdo->lastInsertId()))
		{
			return false;
		}
		else{
			return true;
		}
		
		
	}
	
}