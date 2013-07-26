<?php

namespace models\entity;

use Doctrine\ORM\PersistentCollection as Collection;

/**
 * Interface for my entity
 *
 * @category		Models.Model
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
abstract class Entity
{
	/**
	 * Tranform to array
	 *
	 * @param recursion
	 */
	public function toArray($recursion = false)
	{
		$return = get_object_vars($this);
		foreach ($return as $k => $v)
		{
			if ($v instanceof Collection)
			{
				if ($recursion)
				{
					$return[$k] = $v->toArray();

					foreach ($return[$k] as $k2 => $v2)
					{
						$return[$k][$k2] = $v2->toArray();
					}
				}
				else
				{
					unset($return[$k]);
				}
			}
		}

		return $return;
	}

}
