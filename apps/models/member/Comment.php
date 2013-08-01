<?php

namespace models\member;

use models\model\ORMModel as Model;
use models\entity\member\Comments as MainEntity;

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
	public function __construct($entity = "models\\entity\\member\\Comments")
	{
		parent::__construct($entity);
	}

	/**
	 * Load comment from identity
	 *
	 * @param		$identity	Identity Can use ID, UUID or username.
	 * @param		$useId		Query ID column.
	 *
	 * @return		models\entity\member\Comments
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

		return $item;
	}
}
