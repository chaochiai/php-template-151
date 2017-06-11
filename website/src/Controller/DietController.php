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
		//$breakfastRecord = $this->dietService->checkRecordedMeal("Breakfast");
		echo $this->template->render("today.html.php", ["weightLeft" => $weightLeft]);
	}
	public function showTodayWithParam($foodName, $calories) {
		$weightLeft = $this->dietService->WeightLeft();
		echo $this->template->render("today.html.php", ["weightLeft" => $weightLeft], ["foodname" => $foodName], ["calories" => $calories]);
	}
	public function recordMeal(array $data) {
		if(array_key_exists("add", $data)){
			$this->showToday();
			return ;
		}
		if(array_key_exists("recordMeal", $data)){
			if(!isset($data["foodname"]) OR !isset($data["calories"])){
				print($_POST);
				exit();
				$_POST['addRecordMeal'] = "add";
				$this->showTodayWithParam($data["foodname"], $data["calories"]);
				return $data;
			}
			if($this->dietService->recordMeal($data["recordMealType"]))
			{
				header("Location: /today");
			}
			else{
				echo $this->showToday();
			}
		}
	}
}
