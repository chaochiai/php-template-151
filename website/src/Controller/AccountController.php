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
	public function __construct(SimpleTemplateEngine $template, AccountServiceInterface $accountService)
	{
		$this->template = $template;
		$this->accountService = $accountService;
	}

	public function showEditAccount() {
		echo $this->template->render("editAccount.html.php");
	}
	public function showPersonalInformation() {
		echo $this->template->render("personalInformation.html.php");
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
}
