<?php

namespace models\notification;

use ReflectionClass;
use models\FuneatFactory;

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

	/**
	 * Get message
	 *
	 * @param		string		$action
	 * @param		array		$params
	 *
	 * @return		string
	 */
	public static function buildMessage($action, $params = array())
	{
		switch ($action)
		{
			case self::RESTAURANT_ADD :
				return self::_restaurantAdd($params);
			case self::RESTAURANT_EDIT :
				return self::_restaurantEdit($params);
			default :
				return null;
		}
	}

	/**
	 * Restaurant add
	 *
	 * @param		array		$params
	 *
	 * @return		string
	 */
	private static function _restaurantAdd($params)
	{
		$member = FuneatFactory::getMember();

		return $member->email . '新增了一筆餐廳資料';
	}

	/**
	 * Restaurant edit
	 *
	 * @param		array		$params
	 *
	 * @return		string
	 */
	private static function _restaurantEdit($params)
	{
		$member = FuneatFactory::getMember();

		return $member->email . '修改了一筆餐廳資料';
	}

}
