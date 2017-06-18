<?php

namespace chaochiai\Service\Diet;


interface DietServiceInterface
{
	public function WeightLeft();
	public function Calories();
	public function recordMeal($mealType, $foodName, $calories);
	public function showMeals();
	public function deleteMRecord($mRecordId);
	public function recordWeight($weight);
	public function showHistory();
	public function getWeightOverview();
}
