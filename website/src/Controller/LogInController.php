<?php

namespace chaochiai\Controller;

use chaochiai\SimpleTemplateEngine;
use chaochiai\Service\LogIn\LogInServiceInterface;

class LogInController
{
	/**
	 * @var chaochiai\SimpleTemplateEngine Template engines to render output
	 */
	private $template;
	/*
	 * @var \PDO database connection
	 * */
	private $logInService;

	/**
	 * @param chaochiai\SimpleTemplateEngine
	 */
	public function __construct(SimpleTemplateEngine $template, LogInServiceInterface $logInService)
	{
		$this->template = $template;
		$this->logInService = $logInService;
	}

	public function showLogIn() {
		echo $this->template->render("login.html.php");
	}
	public function logIn(array $data) {
		if(!array_key_exists("username", $data) OR !array_key_exists("password", $data)){
			$this->showLogIn();
			return ;
		} 
		if($this->logInService->Authentication($data["username"], $data["password"]))
		{
			$_SESSION["login"] = $data["username"];
			header("Location: /");
		}
		else{			
			echo $this->template->render("login.html.php", ["username" => $data["username"]]);
		}
	}
}
