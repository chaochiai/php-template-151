<?php

namespace chaochiai\Service\Account;


interface AccountServiceInterface
{
	public function EditAccount();
	public function ShowPersonalInformation();
	public function getUrl($email);
	public function setPoint($timePoint, $userId);
	public function resetPassword($key, $newPassword);

}
