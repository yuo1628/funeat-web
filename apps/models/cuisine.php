<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Cuisine model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Cuisine extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\restaurant\\Cuisines")
	{
		parent::__construct($entity);
	}

}
