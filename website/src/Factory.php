<?php

namespace chaochiai;

class Factory {
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
		return new Controller\LogInController($this->getTemplateEngine(), $this->getPDO(), $this->getLogInService());
	}
}