<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Commodity model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Commodity extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\store\\Commodities")
	{
		parent::__construct($entity);
	}

}
