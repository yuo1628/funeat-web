<?php

namespace models\restaurant;

use models\model\ORMModel as Model;

/**
 * Comment model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Comment extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\restaurant\\Comments")
	{
		parent::__construct($entity);
	}

}
