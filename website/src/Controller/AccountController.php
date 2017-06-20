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
	private $mailer;
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
	public function showForgotPasswordWithParam(array $data){
		$_SESSION["csrf"] = bin2hex(random_bytes(50));
		echo $this->template->render("forgotPassword.html.php", $data);
	}
	public function showResetPassword(){
		$_SESSION["csrf"] = bin2hex(random_bytes(50));
		echo $this->template->render("resetPassword.html.php");
	}
	public function showResetPasswordWithParam(array $data){
		$_SESSION["csrf"] = bin2hex(random_bytes(50));
		echo $this->template->render("resetPassword.html.php", $data);
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
	public function resetPassword(array $data) {
		if(!array_key_exists("newPassword", $data) OR !array_key_exists("rePassword", $data)){
			$this->showLogIn();
			return ;
		}
		if(!empty($data["newPassword"]) AND !empty($data["rePassword"]))
		{
			if($data["newPassword"] === $data["rePassword"]){
				if($this->accountService->resetPassword($data["key"], $data["newPassword"])){
					$data["success"] = "1";
					echo $this->showResetPasswordWithParam($data);
				}else{
					echo $this->showResetPassword();
				}
			}else{
				echo "Passwords entered do not match.";
			}
			
		}
	}
	public function sendEmail(array $data){
		$email = $data["email"];
		$return = $this->accountService->getUrl($email);
		$url = $return["url"];
		$timePoint = $return["timePoint"];
		$userId = $return["userId"];
		
		if($url != null){
			$message = (new \Swift_Message())
			->setSubject('[Tomato Diet Planner] Reset password')
			->setFrom(['chantalOchiai@gmail.com' => 'Tomato Diet Planner'])
			->setTo([$email])
			->setBody("Please go to the link to reset your email $url");
			$result = $this->mailer->send($message);
		}
		if(isset($result)){
			if($result === 1){
				if($this->accountService->setPoint($timePoint, $userId)){
					$data["con"] = "con";
					$this->showForgotPasswordWithParam($data);
				}
			}else{
				$this->showForgotPassword();
			}
		}else{
			echo "The email is not existing";
		}
		
	}
}
