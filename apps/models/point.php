<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Point model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Point extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\collection\\Points")
	{
		parent::__construct($entity);
	}

}
