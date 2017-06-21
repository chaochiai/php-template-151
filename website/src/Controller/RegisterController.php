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
		if (isset($_SESSION["empFieldsVal"])) {
			unset($_SESSION['empFieldsVal']);
		}
		if (isset($_SESSION["intFieldsVal"])) {
			unset($_SESSION['intFieldsVal']);
		}
		$_SESSION["csrf"] = bin2hex(random_bytes(50));
		echo $this->template->render("register.html.php");
	}
	public function showRegisterWithParam($data) {
		$_SESSION["csrf"] = bin2hex(random_bytes(50));
		echo $this->template->render("register.html.php", $data);
	}
	public function register(array $data) {
		if($_SESSION["csrf"] != $data["csrf"]){
			$this->showRegister();
			return ;
		}
		if(!array_key_exists("firstname", $data) OR !array_key_exists("lastname", $data) OR !array_key_exists("username", $data) OR !array_key_exists("email", $data) OR !array_key_exists("password", $data) OR !array_key_exists("gender", $data) OR !array_key_exists("weight", $data) OR !array_key_exists("height", $data) OR !array_key_exists("Goal", $data) OR !array_key_exists("goalCalories", $data)){
			$_SESSION["empFieldsVal"] = "Every field must be filled!";
			$this->showRegisterWithParam($data);
				return $data;
		}
		if (empty($data['firstname']) OR empty($data['lastname']) OR empty($data['username']) OR 
				empty($data['email']) OR empty($data['password']) OR empty($data['gender']) OR 
				empty($data['weight']) OR empty($data['height']) OR empty($data['Goal']) OR 
				empty($data['goalCalories'])) {
			
			$_SESSION["empFieldsVal"] = "Every field must be filled!";
			$this->showRegisterWithParam($data);
		}
		else 
		{
			if($data['Goal'] == "Maintain Weight"){
				$data['goalWeight'] = $data['weight'];
			}
			if(!(!is_float($data['weight']) OR !is_int($data['weight'])) OR 
					!(!is_float($data['height']) OR !is_int($data['height'])) OR 
							!(!is_float($data['goalWeight'])  OR !is_int($data['goalWeight'])) OR 
									!(!is_float($data['goalCalories']) OR !is_int($data['goalCalories']))){
				$_SESSION["intFieldsVal"] = "The Weight, Height, Goal Weight and Goal calories field's values must be in numbers!";
				$this->showRegisterWithParam($data);
			}else{
				if($this->registerService->Register($data["firstname"], $data["lastname"], $data["username"], $data["email"], $data["password"], $data["gender"], $data["weight"], $data["height"], $data["Goal"], $data["goalWeight"], $data["goalCalories"]))
				{
					$_SESSION["registerCompleted"] = 1;
					header("Location: /login");
				}
				else{
					echo $this->template->render("register.html.php", ["email" => $data["email"]]);
				}
			}
			
		}
	
		
	}
}
