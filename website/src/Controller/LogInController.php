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
		$_SESSION["csrf"] = bin2hex(random_bytes(50));
		echo $this->template->render("login.html.php");
	}
	public function logIn(array $data) {
		if($_SESSION["csrf"] != $data["csrf"]){
			$this->showLogIn();
			return ;
		}
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
	public function logOut(){
		if (isset($_SESSION["login"])) {
			unset($_SESSION['login']);
		}
		header("Location: /");
	}
}
