<?php

namespace models\entity\collection;

use Doctrine\ORM\Mapping as ORM;
use models\entity\restaurant\Restaurantgroups;

/**
 * Templates ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="templates")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Templates
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
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $preview;

	/**
	 * @var Array
	 *
	 * @ORM\Column(type="text")
	 */
	private $data;

	/**
	 * @var models\entity\restaurant\Restaurantgroups []
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\restaurant\Restaurantgroups")
	 * @ORM\JoinTable(
	 * 	name="Restaurant_Templates_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="restaurants_id", referencedColumnName="id")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="templates_id", referencedColumnName="id")}
	 * )
	 */
	private $restaurantgroups;

	/**
	 * @var Collections
	 *
	 * @ORM\OneToMany(targetEntity="Collections", mappedBy="templates")
	 */
	private $collections;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->setData(array());
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

	public function setPreview($value)
	{
		$this->preview = $value;
	}

	public function getPreview()
	{
		return $this->preview;
	}

	public function setData(array $value)
	{
		$this->data = json_encode($value);
	}

	public function getData()
	{
		return json_decode($this->preview);
	}

	public function setRestaurantgroups($value)
	{
		$this->restaurantgroups = $value;
	}

	public function getrestaurantgroups()
	{
		return $this->restaurantgroups;
	}

	public function setCollections($value)
	{
		$this->collections = $value;
	}

	public function getCollections()
	{
		return $this->collections;
	}

}
