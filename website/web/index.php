<?php

use chaochiai\Factory;

error_reporting(E_ALL);
session_start();
require_once("../vendor/autoload.php");
$config = parse_ini_file(__DIR__."/../config.ini", true);

$factory = new chaochiai\Factory($config);


switch($_SERVER["REQUEST_URI"]) {
	case "/":
		$factory->getIndexController()->homepage();
		$factory->getMailer()->send(
				Swift_Message::newInstance("Subject")
				->setFrom(["chantalochiaiit@gmail.com" => "Your Name"])
				->setTo(["foobar@gmail.com" => "Foos Name"])
				->setBody("Here is the message itself")
				);
		break;
	case "/testroute":
		echo "Test";
		break;
	case "/register":
		$ctr = $factory->getRegisterController();
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			$ctr->showRegister();
		} else 	{
			$ctr->register($_POST);
		}
		break;
	case "/login":
		$ctr = $factory->getLogInController();
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			$ctr->showLogIn();
		} else 	{
			$ctr->logIn($_POST);
		}
		break;
	case "/personalInformation":
		$ctr = $factory->getAccountController();
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			$ctr->showPersonalInformation();
		} else 	{
			$ctr->logIn($_POST);
		}
		break;
	
	case "/logout":
		$ctr = $factory->getLogInController();
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			$ctr->logOut();
		}
		break;
	case "/today":
		$ctr = $factory->getDietController();
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			$ctr->showToday();
		}else 	{
			$ctr->recordMeal($_POST);
		}
		break;
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			$factory->getIndexController()->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

