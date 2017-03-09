<?php

namespace chaochiai\Controller;

use chaochiai\SimpleTemplateEngine;

class IndexController 
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

  public function homepage() {
    echo "INDEX";
  }

  public function greet($name) {
  	echo $this->template->render("hello.html.php", ["name" => $name]);
  }
}
