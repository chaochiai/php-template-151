<?php
namespace chaochiai\Service\Diet;

class DietPDOService implements DietServiceInterface
{
	private $pdo;
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
}