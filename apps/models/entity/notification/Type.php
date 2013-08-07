<?php

namespace models\entity\notification;

use Doctrine\ORM\Mapping as ORM;

use models\entity\Entity;

/**
 * Type ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="notification_type")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Type extends Entity
{
	/**
	 * The constants for query by columns.
	 *
	 * @var string
	 */
	const COLUMN_ID = 'id';

	/**
	 * @var integer
	 *
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	protected $action;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	protected $template;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $language = '*';

	/**
	 * Constructor
	 */
	public function __construct()
	{
	}

	/**
	 * Cloneable
	 */
	public function __clone()
	{
	}

	public function __get($key)
	{
		return $this->$key;
	}

	public function __set($key, $value)
	{
		$this->$key = $value;
	}

}
