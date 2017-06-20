<?php

namespace chaochiai\Controller;

use chaochiai\SimpleTemplateEngine;
use chaochiai\Service\Diet\DietServiceInterface;

class DietController
{
	/**
	 * @var chaochiai\SimpleTemplateEngine Template engines to render output
	 */
	private $template;
	/*
	 * @var \PDO database connection
	 * */
	private $dietService;

	/**
	 * @param chaochiai\SimpleTemplateEngine
	 */
	public function __construct(SimpleTemplateEngine $template, DietServiceInterface $dietService)
	{
		$this->template = $template;
		$this->dietService = $dietService;
	}

	public function showToday() {
		$_SESSION["csrf"] = bin2hex(random_bytes(50));
		$weightLeft = $this->dietService->WeightLeft();
		if($this->dietService->showMeals() == false){
			$data["meals"] = 0;
		} else {
			$data["meals"] = $this->dietService->showMeals();
		}
		$calories = $this->dietService->Calories();
		if(!empty($calories))
		{
			$data["maximumCalories"] = $calories["maximumCalories"];
			$data["caloriesTaken"] = $calories["caloriesTaken"];
			$data["caloriesPercentage"] = $calories["caloriesPercentage"];
		}
		$data["weightToday"] = $this->dietService->showWeightToday();
		$data["weightLeft"] = $weightLeft;
		echo $this->template->render("today.html.php", $data);
	}
	public function showTodayWithParam($foodName, $calories, $weight, $addRecordMeal) {
		$_SESSION["csrf"] = bin2hex(random_bytes(50));
		$weightLeft = $this->dietService->WeightLeft();
		if($this->dietService->showMeals() == false){
			$data["meals"] = 0;
		} else {
			$data["meals"] = $this->dietService->showMeals();
		}
		$calories2 = $this->dietService->Calories();
		if(!empty($calories2))
		{
			$data["maximumCalories"] = $calories2["maximumCalories"];
			$data["caloriesTaken"] = $calories2["caloriesTaken"];
			$data["caloriesPercentage"] = $calories2["caloriesPercentage"];
		}
		$data["weightToday"] = $this->dietService->showWeightToday();
		$data["weightLeft"] = $weightLeft;
		if(isset($addRecordMeal)){
			switch($addRecordMeal)
			{
				case "B":
					$data["addRecordMealB"] = "B";
					break;
				case "L":
					$data["addRecordMealL"] = "L";
					break;
				case "D":
					$data["addRecordMealD"]= "D";
					break;
				case "S":
					$data["addRecordMealS"] = "S";
					break;
			}
		}
		if(!empty($foodName)  OR !empty($calories))
		{
			print_r($data);
			$data['foodname'] = $foodName;
			$data['calories2'] = $calories;
		}else{
			$data['weight'] = $weight;
		}
		if($weight == null){
			$data["addWeight"] = "edit";
		}
		echo $this->template->render("today.html.php", $data);
	}
	public function showYourJourney() {
		$data["overviews"] = $this->dietService->showHistory();
		$weight = $this->dietService->getWeightOverview();
		if(isset($weight["weightMaintained"]) OR isset($weight["weightGained"]) OR isset($weight["weightLostNo"]))
		{
			$data["weightMaintained"] = $weight["weightMaintained"];
			$data["weightGained"] = $weight["weightGained"];
			$data["weightLostNo"] = $weight["weightLostPos"];
		}else{
			$data["weightLostOrGain"] = $weight["weightLost"];
			$data["weightLeft"] = $weight["weightLeft"];
			
		}
		echo $this->template->render("yourJourney.html.php", $data);
	}
	public function recordMeal(array $data) {
		if($_SESSION["csrf"] != $data["csrf"]){
			$this->showToday();
			return ;
		}
		//if(array_key_exists("add", $data) AND !array_key_exists("recordMeal", $data)){
		if(isset($_POST["add"])){
			if(isset($data["addRecordMealB"])){
				$letter = "B";
			}elseif(isset($data["addRecordMealL"])){
				$letter = "L";
			}elseif(isset($data["addRecordMealD"])){
				$letter = "D";
			}elseif(isset($data["addRecordMealS"])){
				$letter = "S";
			}
			$this->showTodayWithParam(null , null, null,	$letter);
		}
		if(array_key_exists("recordMeal", $data)){	
			
			if(empty($data["foodname"]) OR empty($data["caloriesf"])){
				
				switch($data["recordMealType"])
				{
					case "Breakfast":
						$addRecordMeal = "B";
						break;
					case "Lunch":
						$addRecordMeal = "L";
						break;
					case "Dinner":
						$addRecordMeal = "D";
						break;
					case "Snack":
						$addRecordMeal = "S";
						break;
				}
				
				$weight = null;
				
				print_r($data["foodname"]);
				$this->showTodayWithParam($data["foodname"], $data["caloriesf"], $weight, $addRecordMeal);
				
			}
			if(!empty($data["foodname"]) AND !empty($data["caloriesf"]))
			{
				
				if($this->dietService->recordMeal($data["recordMealType"], $data["foodname"], $data["caloriesf"]))
				{
					header("Location: /today");
				}
				else{
					echo $this->showToday();
				}
			}
			
		}
	}
	public function deleteMRecord(array $data)
	{
		if($_SESSION["csrf"] != $data["csrf"]){
			$this->showToday();
			return ;
		}
		$this->dietService->deleteMRecord($data["mriD"]);
		$this->showToday();
	}
	public function recordWeight(array $data) {
		if($_SESSION["csrf"] != $data["csrf"]){
			$this->showToday();
			return ;
		}
		if(isset($data["addWeight"])){
			print_r($data);
			$this->showTodayWithParam(null, null, null, null);
			return ;
		}
		if(array_key_exists("recordWeight", $data)){
				
			if(empty($data["weight"])){
				$foodname = null;
				$calories = null;
				$this->showTodayWithParam($foodname, $calories, $data["weight"], null);
				return $data;
			}
			if(!empty($data["weight"]))
			{
				if($this->dietService->recordWeight($data["weight"]))
				{
					header("Location: /today");
				}
				else{
					echo $this->showToday();
				}
			}
				
		}
	}
}
