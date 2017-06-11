<?php

namespace chaochiai\Service\Diet;


interface DietServiceInterface
{
	public function WeightLeft();
	public function recordMeal($mealType, $foodName, $calories);
}
