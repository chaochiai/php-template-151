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
		echo $this->template->render("register.html.php");
	}
	public function register(array $data) {
		if(!array_key_exists("firstname", $data) OR !array_key_exists("lastname", $data) OR !array_key_exists("username", $data) OR !array_key_exists("email", $data) OR !array_key_exists("password", $data) OR !array_key_exists("gender", $data) OR !array_key_exists("weight", $data) OR !array_key_exists("height", $data) OR !array_key_exists("goalWeight", $data)){
			$this->showRegister();
			return $data;
		}
		
		if($this->registerService->Register($data["firstname"], $data["lastname"], $data["username"], $data["email"], $data["password"], $data["gender"], $data["weight"], $data["height"], $data["goalWeight"]))
		{
			$_SESSION["registerCompleted"] = 1;
			header("Location: /login");
		}
		else{
			echo $this->template->render("register.html.php", ["email" => $data["email"]]);
		}
	}
}
