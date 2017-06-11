<?php
namespace chaochiai\Service\Diet;

class DietPDOService implements DietServiceInterface
{
	private $pdo;
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
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
	public function recordMeal($mealType){
		echo $mealType;
	}
	
}