<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Feature model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Feature extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\restaurant\\Features")
	{
		parent::__construct($entity);
	}

}
