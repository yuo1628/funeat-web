<?php

namespace models\entity\restaurant;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feature ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="feature")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Features
{
	/**
	 * @var integer
	 *
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	private $id;

	/**
	 * @var Restaurants[]
	 *
	 * @ORM\ManyToMany(targetEntity="Restaurants", mappedBy="features")
	 */
	private $restaurants;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $title;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $createAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=15)
	 */
	private $createIP;

	/**
	 * @var CI
	 */
	private $CI;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->CI = get_instance();
	}

	/**
	 * Cloneable
	 */
	public function __clone()
	{
	}

	/**
	 * @ORM\PrePersist
	 */
	public function doRegisterOnPrePersist()
	{
		$this->createAt = new \DateTime('NOW', new \DateTimeZone('Asia/Taipei'));
		$this->createIP = $this->CI->input->server('REMOTE_ADDR');
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
