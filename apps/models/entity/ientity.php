<?php

namespace models\entity;

/**
 * Interface for my entity
 *
 * @category		Models.Model
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
interface IEntity
{
	/**
	 * Tranform to array
	 *
	 * @param recursion
	 */
	public function toArray($recursion = false);
}
