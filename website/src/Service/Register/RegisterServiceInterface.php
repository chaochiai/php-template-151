<?php

namespace chaochiai\Service\Register;


interface RegisterServiceInterface
{
	public function Register($firstname, $lastname, $username, $email, $password, $gender, $weight, $height, $goalWeight);

}
