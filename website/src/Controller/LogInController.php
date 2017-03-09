<?php

namespace chaochiai\Controller;

use chaochiai\SimpleTemplateEngine;

class LogInController
{
	/**
	 * @var chaochiai\SimpleTemplateEngine Template engines to render output
	 */
	private $template;

	/**
	 * @param chaochiai\SimpleTemplateEngine
	 */
	public function __construct(SimpleTemplateEngine $template)
	{
		$this->template = $template;
	}

	public function showLogIn() {
		echo $this->template->render("login.html.php");
	}

}
