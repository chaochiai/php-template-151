<?php

error_reporting(E_ALL);

require_once("../vendor/autoload.php");
$tmpl = new chaochiai\SimpleTemplateEngine(__DIR__ . "/../templates/");

switch($_SERVER["REQUEST_URI"]) {
	case "/":
		(new chaochiai\Controller\IndexController($tmpl))->homepage();
		break;
	case "/testroute":
		echo "Test";
		break;
	case "/login":
		(new chaochiai\Controller\LogInController($tmpl))->showLogIn();
		break;
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			(new chaochiai\Controller\IndexController($tmpl))->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

