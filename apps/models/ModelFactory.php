<?php

namespace models;

/**
 * Model factory
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
abstract class ModelFactory
{
	/**
	 * Store loaded model instance
	 *
	 * @var		array
	 */
	private static $_instances = array();

	/**
	 * Get model instance
	 *
	 * @param		string $model Model's namespace and model's name.
	 */
	public static function getInstance($model)
	{
		$model = trim($model);

		if (!isset(self::$_instances[$model]))
		{
			self::$_instances[$model] = new $model();
		}

		return self::$_instances[$model];
	}

}
