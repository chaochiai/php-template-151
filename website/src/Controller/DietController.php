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
		
		echo $this->template->render("today.html.php", ["weightLeft" => $weightLeft]);
	}
	public function showTodayWithParam($foodName, $calories) {
		$weightLeft = $this->dietService->WeightLeft();
		$data['weightLeft'] = $weightLeft;
		$data['foodname'] = $foodName;
		$data['calories'] = $calories;
		echo $this->template->render("today.html.php", $data);
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
				
				
				$this->showTodayWithParam($data["foodname"], $data["calories"]);
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
}
