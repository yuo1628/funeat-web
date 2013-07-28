<?php

namespace models\entity\restaurant;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection as Collection;
use models\entity\Entity as Entity;
use models\entity\restaurant\Restaurants as Restaurants;

/**
 * Galleries ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="restaurant_galleries")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Galleries extends Entity
{
	/**
	 * Gallery image type
	 *
	 * @var integer
	 */
	const IMAGE = 0;

	/**
	 * Gallery menu type
	 *
	 * @var integer
	 */
	const MENU = 1;

	/**
	 * Upload path
	 *
	 * @var string
	 */
	public static $UPLOAD_CONFIG = array(
		'upload_path' => 'upload/',
		'allowed_types' => 'gif|jpg|png',
		'encrypt_name' => true
	);

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
	 * @ORM\Column(type="string", length=36, unique=true)
	 */
	protected $uuid;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $type;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $title;

	/**
	 * @var Restaurants
	 *
	 * @ORM\ManyToOne(targetEntity="Restaurants", inversedBy="galleries")
	 */
	protected $restaurant;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime")
	 */
	protected $createAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=15)
	 */
	protected $createIP;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $creator;

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

	/**
	 * @ORM\PrePersist
	 */
	public function doRegisterOnPrePersist()
	{
		$CI = get_instance();

		$this->createAt = new \DateTime('NOW', new \DateTimeZone('Asia/Taipei'));
		$this->createIP = $CI->input->server('REMOTE_ADDR');
	}

	public function getCreateAt()
	{
		return $this->createAt;
	}

	public function getCreateIP()
	{
		return $this->createIP;
	}

	public function getCreater()
	{
		return $this->creater;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getRestaurant()
	{
		return $this->restaurant;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setCreater($v)
	{
		$this->creater = $v;
	}

	public function setRestaurant(Restaurants $restaurant)
	{
		$this->restaurant = $restaurant;
	}

	public function setTitle($title)
	{
		$this->title = Entity::preset($title, $this->title);
	}

}
