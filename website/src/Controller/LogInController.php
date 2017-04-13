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
	private $pdo;
	private $logInService;

	/**
	 * @param chaochiai\SimpleTemplateEngine
	 */
	public function __construct(SimpleTemplateEngine $template, \PDO $pdo, LogInServiceInterface $logInService)
	{
		$this->template = $template;
		$this->pdo = $pdo;
		$this->logInService = $logInService;
	}

	public function showLogIn() {
		echo $this->template->render("login.html.php");
	}
	public function logIn(array $data) {
		if(!array_key_exists("email", $data) OR !array_key_exists("password", $data)){
			$this->showLogIn();
			return ;
		} 
		if($this->logInService->Authentication($data["email"], $data["password"]))
		{
			$_SESSION["email"] = $data["email"];
			header("Location: /");
		}
		else{			
			echo $this->template->render("login.html.php", ["email" => $data["email"]]);
		}
	}
}
