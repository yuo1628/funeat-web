<?php

namespace models;

use models\model\Model as Model;

/**
 * Store model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Store extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\store\\Stores")
	{
		parent::__construct($entity);
	}

}
