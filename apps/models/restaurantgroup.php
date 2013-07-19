<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Restaurantgroup model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Restaurantgroup extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\restaurant\\Restaurantgroup")
	{
		parent::__construct($entity);
	}

}
