<?php

namespace chaochiai;

class Factory {
	private $config;
	public function __construct(array $config)
	{
		$this->config = $config; 
		
	}
	public function getTemplateEngine()
	{
		return new SimpleTemplateEngine(__DIR__ . "/../templates/");
	}
	public function getPDO()
	{
		return new \PDO(
		"mysql:host=mariadb;dbname=app;charset=utf8",
		"root",
		"my-secret-pw",
		[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
	}
	public function getLogInService()
	{
		return new Service\LogIn\LogInPDOService($this->getPDO());
	}
	public function getIndexController()
	{
		return new Controller\IndexController($this->getTemplateEngine());
	}
	public function getLogInController()
	{
		return new Controller\LogInController($this->getTemplateEngine(), $this->getLogInService());
	}
	public function getMailer()
	{
		return \Swift_Mailer::newInstance(
				\Swift_SmtpTransport::newInstance("smtp.gmail.com", 465, "ssl")
				->setUsername("@gmail.com")
				->setPassword("")
				);
	}
	public function getRegisterService()
	{
		return new Service\Register\RegisterPDOService($this->getPDO());
	}
	public function getRegisterController()
	{
		return new Controller\RegisterController($this->getTemplateEngine(), $this->getRegisterService());
	}
	public function getAccountService()
	{
		return new Service\Account\AccountPDOService($this->getPDO());
	}
	public function getAccountController()
	{
		return new Controller\AccountController($this->getTemplateEngine(), $this->getAccountService());
	}
}