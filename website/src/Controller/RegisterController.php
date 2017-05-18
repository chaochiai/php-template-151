<?php

namespace chaochiai\Controller;

use chaochiai\SimpleTemplateEngine;
use chaochiai\Service\Register\RegisterServiceInterface;

class RegisterController
{
	/**
	 * @var chaochiai\SimpleTemplateEngine Template engines to render output
	 */
	private $template;
	/*
	 * @var \PDO database connection
	 * */
	private $registerService;

	/**
	 * @param chaochiai\SimpleTemplateEngine
	 */
	public function __construct(SimpleTemplateEngine $template, RegisterServiceInterface $registerService)
	{
		$this->template = $template;
		$this->registerService = $registerService;
	}

	public function showRegister() {
		echo $this->template->render("login.html.php");
	}
	public function register(array $data) {
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
