<?php

namespace models\notification;

use ReflectionClass;

/**
 * Type action constants
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
abstract class Action
{
	/**
	 * Action constants
	 */
	const RESTAURANT_ADD = 'restaurant/add';
	const RESTAURANT_EDIT = 'restaursnt/edit';

	/**
	 * Get action array
	 *
	 * @return		array
	 */
	public static function getActions()
	{
		$reflect = new ReflectionClass('models\\notification\\Action');
		return $reflect->getConstants();
	}

}
