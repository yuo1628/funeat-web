<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Template model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Template extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\collection\\Templates")
	{
		parent::__construct($entity);
	}

}
