<?php

namespace models\entity\restaurant;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuisines ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="cuisines")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Cuisines
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
	 * @var string
	 *
	 * @ORM\Column(type="string")
	 */
	private $title;

	/**
	 * @var text
	 *
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $info;

	/**
	 * @var Array
	 *
	 * @ORM\Column(type="text")
	 */
	private $data;

	/**
	 * @var Restaurantgroups
	 *
	 * @ORM\ManyToOne(targetEntity="Restaurantgroups", inversedBy="cuisines")
	 */
	private $restaurantgroups;

	/**
	 * @var Restaurants[]
	 *
	 * @ORM\ManyToMany(targetEntity="Restaurants", mappedBy="cuisines")
	 */
	private $restaurants;

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

	public function getId()
	{
		return $this->id;
	}

	public function setTitle($value)
	{
		$this->title = $value;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setInfo($value)
	{
		$this->info = $value;
	}

	public function getInfo()
	{
		return $this->info;
	}

	public function setData(array $value)
	{
		$this->data = json_encode($value);
	}

	public function getData()
	{
		return json_decode($this->data);
	}

	public function setRestaurantgroups(Restaurantgroups $value)
	{
		$this->restaurantgroups = $value;
	}

	public function getRestaurantgroups()
	{
		return $this->restaurantgroups;
	}

	public function setRestaurants(Restaurant $value)
	{
		$this->restaurants = $value;
	}

	public function getRestaurants()
	{
		return $this->restaurants;
	}

}
