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
		
		$stmt2 = $this->pdo->prepare("SELECT * FROM Overview WHERE userId=?");
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
	public function Calories(){
		$id = $this->getUserId();
		$stmt = $this->pdo->prepare("SELECT caloriesGoalIntake FROM User WHERE id=?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		
		if($stmt->rowCount() == 1){
			$result = $stmt->fetch($this->pdo::FETCH_OBJ);
			$data["maximumCalories"] = $result->caloriesGoalIntake;
		}else{
			$data["maximumCalories"] = false;
		}
		$date = date("Y-m-d");
		$caloriesTaken = 0;
		$stmt = $this->pdo->prepare("SELECT m.Calories FROM MealRecord as mr INNER JOIN Meal as m ON mr.mealId = m.id WHERE mr.userId=? AND mr.Date =?");
		$stmt->bindValue(1, $id);
		$stmt->bindValue(2, $date);
		$stmt->execute();
		if($stmt->rowCount() > 0){
			$result = $stmt->fetchAll();			
			foreach($result as $record)
			{
				$caloriesTaken = $caloriesTaken + $record["Calories"];
			}
			$data["caloriesTaken"] = $caloriesTaken;
		} else{
			$data["caloriesTaken"] = false;
		}
		if(!empty($data["maximumCalories"]) AND !empty($data["caloriesTaken"])){
			$data["caloriesPercentage"] = 100 * $data["caloriesTaken"] / $data["maximumCalories"];
		} else{
			$data["caloriesPercentage"] = false;
		}
		return $data;
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
		$date = date("Y-m-d"); 
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
			$this->addOrUpdateOverview();
			return true;
		}
	}
	public function showMeals(){
		$date = date("Y-m-d");
		$userId = $this->getUserId();
		$stmt = $this->pdo->prepare("SELECT mr.id, mr.mealType, m.Name, m.Calories FROM MealRecord as mr INNER JOIN Meal as m ON mr.mealId = m.id 
				WHERE mr.userId=? AND mr.Date=?");
		$stmt->bindValue(1, $userId);
		$stmt->bindValue(2, $date);
		$stmt->execute();
		
		if($stmt->rowCount() > 0){
			$result = $stmt->fetchAll();
			return $result;
		} else{
			return false;
		}
		
	}
	public function deleteMRecord($mRecordId)
	{
		$stmt = $this->pdo->prepare("DELETE FROM MealRecord WHERE id=?");
		$stmt->bindValue(1, $mRecordId);
		$stmt->execute();
		$this->addOrUpdateOverview();
	}
	public function addOrUpdateOverview(){
		//validate if it exist
		$date = date("Y-m-d");
		$userId = $this->getUserId();
		$stmt4 = $this->pdo->prepare("SELECT * FROM Overview WHERE userId=? AND date=?");
		$stmt4->bindValue(1, $userId);
		$stmt4->bindValue(2, $date);
		$stmt4->execute();
		//calories
		$calories = 0;
		$stmt = $this->pdo->prepare("SELECT m.Calories FROM MealRecord as mr INNER JOIN Meal as m ON mr.mealId = m.id WHERE mr.userId=? AND mr.Date =?");
		$stmt->bindValue(1, $userId);
		$stmt->bindValue(2, $date);
		$stmt->execute();
		if($stmt->rowCount() > 0){
			$result = $stmt->fetchAll();
			foreach($result as $record)
			{
				$calories = $calories + $record["Calories"];
			}
		}
		//if it exist, update
		if($stmt4->rowCount() == 1){
			$stmt5 = $this->pdo->prepare("UPDATE Overview SET calories = ?  WHERE userId=? AND date=?");
			$stmt5->bindValue(1, $calories);
			$stmt5->bindValue(2, $userId);
			$stmt5->bindValue(3, $date);
			$stmt5->execute();
		} else{
			//weight
			$stmt7 = $this->pdo->prepare("SELECT * FROM Overview WHERE userId=? ORDER BY id DESC LIMIT 1");
			$stmt7->bindValue(1, $userId);
			$stmt7->execute();
			if($stmt7->rowCount() == 1){
				$result = $stmt7->fetch($this->pdo::FETCH_OBJ);
				$weight = $result->weight;
			}else{
				$stmt8 = $this->pdo->prepare("SELECT * FROM User WHERE id=?");
				$stmt8->bindValue(1, $userId);
				$stmt8->execute();
				$result = $stmt8->fetch($this->pdo::FETCH_OBJ);
				$weight = $result->currentWeight;
			}
			$stmt6 = $this->pdo->prepare("INSERT INTO Overview (userId, weight, date, calories) VALUES(?,?,?,?) ");
			$stmt6->bindValue(1, $userId);
			$stmt6->bindValue(2, $weight);
			$stmt6->bindValue(3, $date);
			$stmt6->bindValue(4, $calories);
			$stmt6->execute();
		}
	}
	public function showWeightToday(){
		$userId = $this->getUserId();
		$date = date("Y-m-d");
		$stmt = $this->pdo->prepare("SELECT * FROM Overview WHERE userId=? AND date=?");
		$stmt->bindValue(1, $userId);
		$stmt->bindValue(2, $date);
		$stmt->execute();
		
		if($stmt->rowCount() == 1){
			$result = $stmt->fetch($this->pdo::FETCH_OBJ);
			return $result->weight;
		} else{
			$stmt2 = $this->pdo->prepare("SELECT * FROM Overview WHERE userId=? ORDER BY id DESC LIMIT 1");
			$stmt2->bindValue(1, $userId);
			$stmt2->execute();
			if($stmt2->rowCount() == 1){
				$result = $stmt2->fetch($this->pdo::FETCH_OBJ);
				return $result->weight;
			}else{
				$stmt3 = $this->pdo->prepare("SELECT * FROM User WHERE id=?");
				$stmt3->bindValue(1, $userId);
				$stmt3->execute();
				$result = $stmt3->fetch($this->pdo::FETCH_OBJ);
				return $result->currentWeight;
			}
		}
		
	}
	public function recordWeight($weight){
		//validation overview already exist
		$userId = $this->getUserId();
		$date = date("Y-m-d");
		$stmt = $this->pdo->prepare("SELECT * FROM Overview WHERE userId=? AND date=?");
		$stmt->bindValue(1, $userId);
		$stmt->bindValue(2, $date);
		$stmt->execute();
	
		if($stmt->rowCount() == 1){	
			$stmt3 = $this->pdo->prepare("UPDATE Overview SET weight = ?  WHERE userId=? AND date=?");
			$stmt3->bindValue(1, $weight);
			$stmt3->bindValue(2, $userId);
			$stmt3->bindValue(3, $date);
			$stmt3->execute();
		} else{
			//calories
			$calories = 0;
			$stmt4 = $this->pdo->prepare("SELECT m.Calories FROM MealRecord as mr INNER JOIN Meal as m ON mr.mealId = m.id WHERE mr.userId=? AND mr.Date =?");
			$stmt4->bindValue(1, $userId);
			$stmt4->bindValue(2, $date);
			$stmt4->execute();
			if($stmt4->rowCount() > 0){
				$result = $stmt4->fetchAll();
				foreach($result as $record)
				{
					$calories = $calories + $record["Calories"];
				}
			}		
			
			$stmt2 = $this->pdo->prepare("INSERT INTO Overview (userId, weight, date, calories) VALUES (?,?,?,?)");
			$stmt2->bindParam(1, $userId);
			$stmt2->bindParam(2, $weight);
			$stmt2->bindParam(3, $date);
			$stmt2->bindParam(4, $calories);
			$stmt2->execute();
		}
		if(empty($this->pdo->lastInsertId()))
		{
			return false;
		}
		else{
			return true;
		}
	}
	public function showHistory(){
		$userId = $this->getUserId();
		$stmt = $this->pdo->prepare("SELECT * FROM Overview WHERE userId=?");
		$stmt->bindValue(1, $userId);
		$stmt->execute();
		
		if($stmt->rowCount() > 0){
			$result = $stmt->fetchAll();
			return $result;
		} else{
			return false;
		}
	}
	public function getWeightOverview(){
		$userId = $this->getUserId();
		$stmt = $this->pdo->prepare("SELECT * FROM User WHERE id=?");
		$stmt->bindValue(1, $userId);
		$stmt->execute();
		if($stmt->rowCount() == 1){
			$result = $stmt->fetch($this->pdo::FETCH_OBJ);
			$currentWeight = $result->currentWeight;
			$goalWeight = $result->goalWeight;
		}
		$stmt2 = $this->pdo->prepare("SELECT * FROM Overview WHERE userId=? ORDER BY id DESC LIMIT 1");
		$stmt2->bindValue(1, $userId);
		$stmt2->execute();
		if($stmt2->rowCount() == 1){
			$result2 = $stmt2->fetch($this->pdo::FETCH_OBJ);
			$weight = $result2->weight;
		}else {
			$weight = $currentWeight;
		}
		switch($result->Goal)
		{
			case 'Lose Weight':
				$data["weightLost"] = $currentWeight - $weight;
				$data["weightLeft"] = $weight - $goalWeight;
				break;
			case 'Maintain Weight':
				$data = null;
				break;
			case 'Gain Weight':
				$data["weightLost"] = $weight - $currentWeight;
				$data["weightLeft"] = $goalWeight - $weight;
				break;
		}
		return $data;
	}
}