<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Member model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Member extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\member\\Members")
	{
		parent::__construct($entity);
	}
}
