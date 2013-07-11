<?php

namespace models\entity\store;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commodities ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="commodities")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Commodities
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
	 * @var Storegroups
	 *
     * @ORM\ManyToOne(targetEntity="Storegroups", inversedBy="commodities")
	 */
	private $storegroups;

	/**
	 * @var Stores []
	 *
	 * @ORM\ManyToMany(targetEntity="Stores", mappedBy="commodities")
	 */
	private $stores;

	/**
	 * Constructor
	 */
	public function __construct()
	{

	}

	/**
	 * Cloneable
	 */
	public function __clone() {}

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

    public function setStoregroups(Storegroups $value)
    {
        $this->storegroups = $value;
    }

    public function getStoregroups()
    {
        return $this->storegroups;
    }

    public function setStores(Storegroups $value)
    {
        $this->stores = $value;
    }

    public function getStores()
    {
        return $this->stores;
    }
}
