<?php

namespace models;

use models\model\ORMModel as Model;

/**
 * Notification model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Notification extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = 'models\\entity\\notification\\Notifications')
	{
		parent::__construct($entity);
	}

}
