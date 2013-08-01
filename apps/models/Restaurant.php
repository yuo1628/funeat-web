<?php

namespace models;

use models\model\ORMModel as Model;
use models\entity\restaurant\Restaurants as MainEntity;

/**
 * Restaurant model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Restaurant extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\restaurant\\Restaurants")
	{
		parent::__construct($entity);
	}

	/**
	 * Get restaurant by identity
	 *
	 * @param		$identity	Identity Can use ID, UUID or username.
	 * @param		$useId		Query ID column.
	 *
	 * @return		models\entity\restaurant\Restaurants
	 */
	public function getItemByIdentity($identity, $useId = false)
	{
		$identity = trim($identity);

		$CI = get_instance();
		$CI->load->library('uuid');

		$item = null;

		if ($CI->uuid->is_valid($identity))
		{
			$item = $this->getItem($identity, MainEntity::COLUMN_UUID);
		}
		elseif ((int)$identity > 0 && $useId)
		{
			// integer
			$item = $this->getItem((int)$identity);
		}
		elseif (preg_match('/^\w+$/', $identity))
		{
			// match [0-9a-zA-Z_]+
			$item = $this->getItem($identity, MainEntity::COLUMN_USERNAME);
		}

		return $item;
	}
}
