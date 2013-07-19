<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Storegroup model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Storegroup extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\store\\Storegroup")
	{
		parent::__construct($entity);
	}

}
