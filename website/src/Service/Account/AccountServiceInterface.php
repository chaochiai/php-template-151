<?php

namespace chaochiai\Service\Account;


interface AccountServiceInterface
{
	public function EditAccount($firstname, $lastname, $username, $email, $gender, $weight, $height, $goal, $goalWeight, $goalCalories);
	public function ShowPersonalInformation();
	public function getUrl($email);
	public function setPoint($timePoint, $userId);
	public function resetPassword($key, $newPassword);
	public function deleteAccount();
	public function getUserData();
}
