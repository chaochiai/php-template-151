<?php

namespace ihrname\Controller;

use ihrname\SimpleTemplateEngine;

class LogInController
{
	/**
	 * @var ihrname\SimpleTemplateEngine Template engines to render output
	 */
	private $template;

	/**
	 * @param ihrname\SimpleTemplateEngine
	 */
	public function __construct(SimpleTemplateEngine $template)
	{
		$this->template = $template;
	}

	public function showLogIn() {
		echo $this->template->render("login.html.php");
	}

}
