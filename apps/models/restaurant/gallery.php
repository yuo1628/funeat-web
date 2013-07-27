<?php

namespace models\restaurant;

use models\model\ORMModel as Model;

/**
 * Gallery model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Gallery extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\restaurant\\Galleries")
	{
		parent::__construct($entity);
	}

}
