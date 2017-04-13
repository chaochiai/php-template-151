<?php

use chaochiai\Factory;

error_reporting(E_ALL);
session_start();
require_once("../vendor/autoload.php");
$config = parse_ini_file(__DIR__."/../config.ini", true);
var_dump($config["database"]["password"]);
$factory = new chaochiai\Factory($config);


switch($_SERVER["REQUEST_URI"]) {
	case "/":
		$factory->getIndexController()->homepage();
		break;
	case "/testroute":
		echo "Test";
		break;
	case "/login":
		$ctr = $factory->getLogInController();
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			$ctr->showLogIn();
		} else 	{
			$ctr->logIn($_POST);
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

