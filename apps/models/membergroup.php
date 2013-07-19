<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Membergroup model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Membergroup extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\member\\Membergroups")
	{
		parent::__construct($entity);
	}

}
