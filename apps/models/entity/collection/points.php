<?php

namespace models\entity\collection;

use Doctrine\ORM\Mapping as ORM;
use models\entity\store\Stores;

/**
 * Points ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="points")
 * @ORM\Entity
 */
class Points
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
	 * @ORM\Column(type="string", length=255, unique=true)
	 */
	private $code;

	/**
	 * @var Stores
	 *
	 * @ORM\ManyToOne(targetEntity="models\entity\store\Stores", inversedBy="points")
	 */
	private $store;

	/**
	 * @var Collections
	 *
	 * @ORM\Column(nullable=true)
	 * @ORM\ManyToOne(targetEntity="Collections", inversedBy="points", cascade={"persist"})
	 */
	private $collection;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $startDate;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $endDate;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(type="boolean")
	 */
	private $activated;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(type="boolean")
	 */
	private $destroyed;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->code = md5(uniqid(mt_rand(), true));
		$this->startDate = new \DateTime('NOW', new \DateTimeZone('Asia/Taipei'));
		$this->endDate = new \DateTime('NOW', new \DateTimeZone('Asia/Taipei'));
		$this->activated = false;
		$this->destroyed = false;
	}

	/**
	 * Cloneable
	 */
	public function __clone() {}

    public function getId()
    {
        return $this->id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setStore(Stores $value)
    {
        $this->store = $value;
    }

    public function getStore()
    {
        return $this->store;
    }

    public function setCollection(Collections $value)
    {
        $this->collections = $value;
    }

    public function getCollection()
    {
        return $this->collections;
    }

    public function setStartDate(DateTime $value)
    {
        $this->startDate = $value;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setEndDate(DateTime $value)
    {
        $this->endDate = $value;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setActivated($value)
    {
        $this->activated = (boolean) $value;
    }

    public function getActivated()
    {
        return $this->activated;
    }

    public function setDestroyed($value)
    {
        $this->destroyed = (boolean) $value;
    }

    public function getDestroyed()
    {
        return $this->destroyed;
    }

}
