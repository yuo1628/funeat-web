<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Collection model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Collection extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\collection\\Collections")
	{
		parent::__construct($entity);
	}
}
