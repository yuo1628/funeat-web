<?php

namespace models\entity\member;

use Doctrine\ORM\Mapping as ORM;
use models\entity\Entity;

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
class Members extends Entity
{
	/**
	 * The constants for query by columns.
	 *
	 * @var string
	 */
	const COLUMN_ID = 'id';
	const COLUMN_UUID = 'uuid';
	const COLUMN_USERNAME = 'username';

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
	 * @var Membergroups[]
	 *
	 * @ORM\ManyToMany(targetEntity="Membergroups")
	 * @ORM\JoinTable(
	 * 	name="Member_Groups_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="members_id", referencedColumnName="id")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="membergroups_id", referencedColumnName="id")}
	 * )
	 */
	protected $membergroups;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, unique=true, nullable=false)
	 */
	protected $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $username;

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
	protected $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=32, nullable=true)
	 */
	protected $avatar;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime", length=32)
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
	 * @ORM\Column(type="smallint", nullable=true)
	 */
	protected $gender;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $birthday;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $nickname;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $website;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $interest;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $intro;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $country;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $language;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $metadata;

	/**
	 * @var models\entity\member\Members[]
	 *
	 * @ORM\ManyToMany(targetEntity="Members")
	 * @ORM\JoinTable(name="Members_Like_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="members_id", referencedColumnName="id", onDelete="CASCADE")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="like_members_id", referencedColumnName="id")}
	 * )
	 */
	protected $like;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="smallint")
	 */
	protected $activated;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="smallint")
	 */
	protected $blocked;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="smallint")
	 */
	protected $deleted;

	/**
	 * @var Collection[]
	 *
	 * @ORM\OneToMany(targetEntity="models\entity\collection\Collections", mappedBy="members")
	 */
	protected $collection;

	/**
	 * @var Restaurants[]
	 *
	 * @ORM\OneToMany(targetEntity="models\entity\restaurant\Restaurants", mappedBy="members")
	 */
	protected $restaurantOwner;

	/**
	 * @var Restaurants[]
	 *
	 * @ORM\OneToMany(targetEntity="models\entity\restaurant\Restaurants", mappedBy="members")
	 */
	protected $restaurantCreated;

	/**
	 * @var models\entity\restaurant\Restaurants[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\restaurant\Restaurants", mappedBy="members")
	 */
	protected $restaurantLike;

	/**
	 * @var models\entity\restaurant\Restaurants[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\restaurant\Restaurants", mappedBy="members")
	 */
	protected $restaurantDislike;

	/**
	 * @var models\entity\restaurant\Comments[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\restaurant\Comments", mappedBy="members")
	 */
	protected $commentsLike;

	/**
	 * @var models\entity\image\Images[]
	 *
	 * @ORM\OneToMany(targetEntity="models\entity\image\Images", mappedBy="members")
	 */
	protected $imageOwn;

	/**
	 * @var models\entity\member\Members[]
	 *
	 * @ORM\ManyToMany(targetEntity="Members", mappedBy="members")
	 */
	protected $memberLike;

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
		$CI = get_instance();
		$CI->load->library('uuid');

		$this->uuid = $CI->uuid->v4();
		$this->createAt = new \DateTime('NOW', new \DateTimeZone('Asia/Taipei'));
		$this->createIP = $CI->input->server('REMOTE_ADDR');
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

	/**
	 * Get like member collection
	 *
	 * @return		models\entity\member\Members[]
	 */
	public function getLike()
	{
		return $this->like;
	}

	public function setMembergroups(Membergroups $value)
	{
		$this->membergroups = $value;
	}

	public function getMembergroups()
	{
		return $this->membergroups;
	}


	public function getUuid()
	{
		return $this->uuid;
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
