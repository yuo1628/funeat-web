<?php

namespace models\entity\collection;

use Doctrine\ORM\Mapping as ORM;
use models\entity\member\Members;

/**
 * Collections ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="collections")
 * @ORM\Entity
 */
class Collections
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
	 * @var Template
	 *
	 * @ORM\ManyToOne(targetEntity="Templates", inversedBy="collection")
	 */
	private $template;

	/**
	 * @var Members
	 *
	 * @ORM\ManyToOne(targetEntity="models\entity\member\Members", inversedBy="collection")
	 */
	private $member;

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
	 * @var Points[]
	 *
	 * @ORM\OneToMany(targetEntity="Points", mappedBy="collections")
	 */
	private $points;

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
	public function __clone()
	{
	}

	public function getId()
	{
		return $this->id;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function setTemplate(Templates $value)
	{
		$this->template = $value;
	}

	public function getTemplate()
	{
		return $this->template;
	}

	public function setMember(Members $value)
	{
		$this->member = $value;
	}

	public function getMember()
	{
		return $this->member;
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
		$this->activated = (boolean)$value;
	}

	public function getActivated()
	{
		return $this->activated;
	}

	public function setDestroyed($value)
	{
		$this->destroyed = (boolean)$value;
	}

	public function getDestroyed()
	{
		return $this->destroyed;
	}

	public function getPoints()
	{
		return $this->points;
	}

}
