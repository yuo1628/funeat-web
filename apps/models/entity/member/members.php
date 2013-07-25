<?php

namespace models\entity\member;

use Doctrine\ORM\Mapping as ORM;

/**
 * Members ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="members")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Members
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
	 * @var Membergroups[]
	 *
	 * @ORM\ManyToMany(targetEntity="Membergroups")
	 * @ORM\JoinTable(
	 * 	name="Member_Groups_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="members_id", referencedColumnName="id")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="membergroups_id", referencedColumnName="id")}
	 * )
	 */
	private $membergroups;

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
	 * @ORM\Column(type="string", length=32, nullable=true)
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
	 * @var integer
	 *
	 * @ORM\Column(type="smallint", nullable=true)
	 */
	private $gender;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $birthday;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $nickname;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $website;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $interest;

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
	 * @var Collection[]
	 *
	 * @ORM\OneToMany(targetEntity="models\entity\collection\Collections", mappedBy="members")
	 */
	private $collection;

	/**
	 * @var Restaurants[]
	 *
	 * @ORM\OneToMany(targetEntity="models\entity\restaurant\Restaurants", mappedBy="members")
	 */
	private $restaurantOwner;

	/**
	 * @var Restaurants[]
	 *
	 * @ORM\OneToMany(targetEntity="models\entity\restaurant\Restaurants", mappedBy="members")
	 */
	private $restaurantCreated;

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

	public function setMembergroups(Membergroups $value)
	{
		$this->membergroups = $value;
	}

	public function getMembergroups()
	{
		return $this->membergroups;
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
