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
	public function showTodayWithParam($foodName, $calories, $weight) {
		$weightLeft = $this->dietService->WeightLeft();
		$data['weightLeft'] = $weightLeft;
		if($foodName != null AND $calories != null)
		{
			$data['foodname'] = $foodName;
			$data['calories'] = $calories;
		}else{
			$data['weight'] = $weight;
		}
		
		echo $this->template->render("today.html.php", $data);
	}
	public function showYourJourney() {
		$data["overviews"] = $this->dietService->showHistory();
		$weight = $this->dietService->getWeightOverview();
		if($weight != null)
		{
			$data["weightLostOrGain"] = $weight["weightLost"];
			$data["weightLeft"] = $weight["weightLeft"];
		}else{
			$data = $weight;
		}
		echo $this->template->render("yourJourney.html.php", $data);
	}
	public function recordMeal(array $data) {
		if(array_key_exists("add", $data)){
			$this->showToday();
			return ;
		}
		if(array_key_exists("recordMeal", $data)){	
			
			if(empty($data["foodname"]) OR empty($data["calories"])){
				switch($data["recordMealType"])
				{
					case "Breakfast":
						$_POST['addRecordMealB'] = "add";
						break;
					case "Lunch":
						$_POST['addRecordMealL'] = "add";
						break;
					case "Dinner":
						$_POST['addRecordMealD'] = "add";
						break;
					case "Snack":
						$_POST['addRecordMealS'] = "add";
						break;
				}
				
				$weight = null;
				$this->showTodayWithParam($data["foodname"], $data["calories"], $weight);
				return $data;
			}
			if(!empty($data["foodname"]) OR !empty($data["calories"]))
			{
				if($this->dietService->recordMeal($data["recordMealType"], $data["foodname"], $data["calories"]))
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
		$this->dietService->deleteMRecord($data["mriD"]);
		$this->showToday();
	}
	public function recordWeight(array $data) {
		if(array_key_exists("addWeight", $data)){
			$this->showToday();
			return ;
		}
		if(array_key_exists("recordWeight", $data)){
				
			if(empty($data["weight"])){
				$_POST['addWeight'] = "add";
				$foodname = null;
				$calories = null;
				$this->showTodayWithParam($foodname, $calories, $data["weight"]);
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
