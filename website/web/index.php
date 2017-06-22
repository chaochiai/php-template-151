<?php

use chaochiai\Factory;

error_reporting(E_ALL);
session_start();
require_once("../vendor/autoload.php");
$config = parse_ini_file(__DIR__."/../config.ini", true);

$factory = new chaochiai\Factory($config);

$requestUrl = explode('?', $_SERVER["REQUEST_URI"])[0];

switch($requestUrl) {
	case "/":
		$factory->getIndexController()->homepage();
		
		break;
	case "/forgotPassword":
		$ctr = $factory->getAccountController();
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			$ctr->showForgotPassword();
		} else 	{
			if($_SESSION["csrf"] != $_POST["csrf"]){
				$ctr->showForgotPassword();
			}else{
				$ctr->sendEmail($_POST);
			}
		}
		break;
	case "/resetpassword":
		$ctr = $factory->getAccountController();
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			$ctr->showResetPassword();
		} else 	{
			if($_SESSION["csrf"] != $_POST["csrf"]){
				$ctr->showResetPassword();
			}else{
				$_POST["key"] = $_GET["key"];;
				$ctr->resetPassword($_POST);
			}
		}
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
			$ctr = $factory->getAccountController();
			$ctr->deleteAccount();
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
			if(isset($_POST["recordMeal"]) OR isset($_POST["addRecordMealB"]) OR isset($_POST["addRecordMealL"]) OR isset($_POST["addRecordMealD"])OR isset($_POST["addRecordMealS"]))
			{
				$ctr->recordMeal($_POST);
			}
			else if(isset($_POST["deleteMRecord"]))
			{
				$ctr->deleteMRecord($_POST);
			}else if(isset($_POST["addWeight"]) OR isset($_POST["recordWeight"]))
			{
				$ctr->recordWeight($_POST);
			}
		}
		break;
	case "/yourJourney":
		$ctr = $factory->getDietController();
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			$ctr->showYourJourney();
		}
		break;
	default:
		$factory->getIndexController()->homepage();
		break;
		echo "Not Found";
}

