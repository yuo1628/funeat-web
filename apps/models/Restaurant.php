<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Restaurant model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Restaurant extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\restaurant\\Restaurants")
	{
		parent::__construct($entity);
	}

}
