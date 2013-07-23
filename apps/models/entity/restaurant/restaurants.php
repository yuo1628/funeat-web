<?php

namespace models\entity\restaurant;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurants ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="restaurants")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Restaurants
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
	 * @var Restaurantgroups[]
	 *
	 * @ORM\ManyToMany(targetEntity="Restaurantgroups")
	 * @ORM\JoinTable(
	 * 	name="Restaurant_Groups_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="restaurants_id", referencedColumnName="id")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="restaurantgroups_id", referencedColumnName="id")}
	 * )
	 */
	private $restaurantgroups;

	/**
	 * @var Cuisines[]
	 *
	 * @ORM\ManyToMany(targetEntity="Cuisines")
	 * @ORM\JoinTable(
	 * 	name="Restaurant_Cuisines_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="restaurants_id", referencedColumnName="id")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="cuisines_id", referencedColumnName="id")}
	 * )
	 */
	private $cuisines;

	/**
	 * @var Features[]
	 *
	 * @ORM\ManyToMany(targetEntity="Features")
	 * @ORM\JoinTable(
	 * 	name="Restaurant_Features_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="restaurants_id", referencedColumnName="id")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="features_id", referencedColumnName="id")}
	 * )
	 */
	private $features;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, unique=true, nullable=false)
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $username;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=32, nullable=false)
	 */
	private $password;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=10, unique=true, nullable=true)
	 */
	private $sn;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=32, nullable=false)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=32, nullable=true)
	 */
	private $avatar;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime", length=32)
	 */
	private $createAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=15)
	 */
	private $createIP;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $website;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $intro;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $address;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $tel;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $country;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $language;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $metadata;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="smallint")
	 */
	private $activated;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="smallint")
	 */
	private $blocked;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="smallint")
	 */
	private $deleted;

	/**
	 * @var Points[]
	 *
	 * @ORM\OneToMany(targetEntity="models\entity\collection\Points", mappedBy="restaurants")
	 */
	private $points;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->activated = 0;
		$this->blocked = 0;
		$this->deleted = 0;
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
		$this->createIP =  get_instance()->input->server('REMOTE_ADDR');
	}

	/**
	 * @ORM\PrePersist
	 */
	public function doEncodeOnPrePersist()
	{
		$this->password = md5($this->password);
	}

	/**
	 * @ORM\PreUpdate
	 */
	public function doEncodeOnPreUpdate()
	{
		$this->password = md5($this->password);
	}

	public function getId()
	{
		return $this->id;
	}

	public function setRestaurantgroups(Restaurantgroups $value)
	{
		$this->restaurantgroups = $value;
	}

	public function getRestaurantgroups()
	{
		return $this->restaurantgroups;
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
