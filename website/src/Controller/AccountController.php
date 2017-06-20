<?php

namespace chaochiai\Controller;

use chaochiai\SimpleTemplateEngine;
use chaochiai\Service\Account\AccountServiceInterface;

class AccountController
{
	/**
	 * @var chaochiai\SimpleTemplateEngine Template engines to render output
	 */
	private $template;
	/*
	 * @var \PDO database connection
	 * */
	private $accountService;

	/**
	 * @param chaochiai\SimpleTemplateEngine
	 */
	public function __construct(SimpleTemplateEngine $template, AccountServiceInterface $accountService, \Swift_Mailer $mailer) 
	{
		$this->template = $template;
		$this->accountService = $accountService;
		$this->mailer = $mailer;
	}

	public function showEditAccount() {
		echo $this->template->render("editAccount.html.php");
	}
	public function showPersonalInformation() {
		$data = $this->accountService->ShowPersonalInformation();
		echo $this->template->render("personalInformation.html.php", $data);
	}
	public function showForgotPassword(){
		$_SESSION["csrf"] = bin2hex(random_bytes(50));
		echo $this->template->render("forgotPassword.html.php");
	}
	public function editAccount(array $data) {
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
	public function sendEmail(array $data){
		$email = $data["email"];
		$message = (new \Swift_Message())
		->setSubject('[Tomato Diet Planner] Reset password')
		->setFrom(['chantalOchiai@gmail.com' => 'Tomato Diet Planner'])
		->setTo([$email])
		->setBody("message"	);
		$this->mailer->send($message);
	}
}
