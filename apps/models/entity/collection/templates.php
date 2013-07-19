<?php

namespace models\entity\collection;

use Doctrine\ORM\Mapping as ORM;
use models\entity\store\Storegroups;

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
	 * @var models\entity\store\Storegroups []
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\store\Storegroups")
	 * @ORM\JoinTable(
	 * 	name="Store_Templates_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="stores_id", referencedColumnName="id")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="templates_id", referencedColumnName="id")}
	 * )
	 */
	private $storegroups;

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

	public function setStoregroups($value)
	{
		$this->storegroups = $value;
	}

	public function getStoregroups()
	{
		return $this->storegroups;
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
