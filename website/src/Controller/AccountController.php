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
		$_SESSION["csrf"] = bin2hex(random_bytes(50));
		$data = $this->accountService->getUserData();
		echo $this->template->render("editAccount.html.php", $data);
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
	public function showThankYou(){
		echo $this->template->render("thankYou.html.php");
	}
	public function editAccount(array $data) {
		if($_SESSION["csrf"] != $data["csrf"]){
			$this->showEditAccount();
			return ;
		}
		if(!array_key_exists("firstname", $data) OR !array_key_exists("lastname", $data) OR !array_key_exists("username", $data) OR !array_key_exists("email", $data) OR !array_key_exists("gender", $data) OR !array_key_exists("weight", $data) OR !array_key_exists("height", $data) OR !array_key_exists("Goal", $data) OR !array_key_exists("goalCalories", $data)){
			$_SESSION["empFieldsVal"] = "Every field must be filled!";
			$this->showRegisterWithParam($data);
			return $data;
		}
		if (empty($data['firstname']) OR empty($data['lastname']) OR empty($data['username']) OR
				empty($data['email']) OR empty($data['gender']) OR
				empty($data['weight']) OR empty($data['height']) OR empty($data['Goal']) OR
				empty($data['goalCalories'])) {
						
					$_SESSION["empFieldsVal"] = "Every field must be filled!";
					echo $this->template->render("editAccount.html.php", $data);
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
								echo $this->template->render("editAccount.html.php", $data);
					}else{
						if($this->accountService->EditAccount($data["firstname"], $data["lastname"], $data["username"], $data["email"], $data["gender"], $data["weight"], $data["height"], $data["Goal"], $data["goalWeight"], $data["goalCalories"]))
						{
							$_SESSION["login"] = $data["username"];
							$this->showPersonalInformation();
						}
						else{
							echo $this->template->render("editAccount.html.php", $data);
						}
					}
						
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
	public function deleteAccount(){
		if($this->accountService->deleteAccount()){
			if (isset($_SESSION["login"])) {
				unset($_SESSION['login']);
			}
			$this->showThankYou();
		}else{
			$this->showPersonalInformation();
		}
	}
}
