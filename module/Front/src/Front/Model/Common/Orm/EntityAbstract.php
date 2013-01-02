<?php

namespace Front\Model\Common\Orm;

abstract class EntityAbstract {
	public function __get($name) {
		$method = 'get' . $name;
		if (!method_exists($this, $method)) {
			throw new Entity\EntityException(sprintf("Brak metody odczytujacej %s dla Encji", $method));
		}
		return $this->$method();
	}
}