<?php

namespace models\notification;

use models\model\ORMModel as Model;

/**
 * Type model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Type extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = 'models\\entity\\notification\\Type')
	{
		parent::__construct($entity);
	}

}
