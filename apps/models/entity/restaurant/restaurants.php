<?php

namespace models\entity\restaurant;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection as Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use models\entity\Entity as Entity;
use models\restaurant\Hours;

/**
 * Restaurants ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="restaurants")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Restaurants extends Entity
{
	/**
	 * @var integer
	 *
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	protected $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=36, unique=true)
	 */
	protected $uuid;

	/**
	 * @Gedmo\TreeLeft
	 * @ORM\Column(name="lft", type="integer")
	 */
	protected $lft;

	/**
	 * @Gedmo\TreeRight
	 * @ORM\Column(name="rgt", type="integer")
	 */
	protected $rgt;

	/**
	 * @Gedmo\TreeLevel
	 * @ORM\Column(name="level", type="integer")
	 */
	protected $level;

	/**
	 * @Gedmo\TreeRoot
	 * @ORM\Column(name="root", type="integer", nullable=true)
	 */
	protected $root;

	/**
	 * @var Restaurants
	 *
	 * @Gedmo\TreeParent
	 * @ORM\ManyToOne(targetEntity="Restaurants", inversedBy="children")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $parent;

	/**
	 * @var Restaurants[]
	 *
	 * @ORM\OneToMany(targetEntity="Restaurants", mappedBy="parent")
	 * @ORM\OrderBy({"lft" = "ASC"})
	 */
	protected $children;

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
	protected $cuisines;

	/**
	 * @var Features[]
	 *
	 * @ORM\ManyToMany(targetEntity="Features")
	 * @ORM\JoinTable(name="Restaurant_Features_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="restaurants_id", referencedColumnName="id", onDelete="CASCADE")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="features_id", referencedColumnName="id")}
	 * )
	 */
	protected $features;

	/**
	 * @var string
	 *
	 * @ORM\ManyToOne(targetEntity="models\entity\member\Members", inversedBy="restaurants")
	 */
	protected $owner;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $username;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=32, nullable=true)
	 */
	private $password;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=10, nullable=true)
	 */
	protected $sn;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $name;

	/**
	 * @var Galleries
	 *
	 * @ORM\OneToOne(targetEntity="Galleries")
 	 * @ORM\JoinColumn(name="galleries_id", referencedColumnName="id", onDelete="CASCADE"))
	 */
	protected $logo;

	/**
	 * @var array
	 *
	 * @ORM\Column(type="json_array", nullable=true)
	 */
	protected $images;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	protected $address;

	/**
	 * @var float
	 *
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $latitude;

	/**
	 * @var float
	 *
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $longitude;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $priceHigh;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $priceLow;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $tel;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $fax;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $website;

	/**
	 * @var models\restaurant\Hours
	 *
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $hours;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $intro;

	/**
	 * @var models\entity\member\Members
	 *
	 * @ORM\ManyToOne(targetEntity="models\entity\member\Members", inversedBy="restaurants")
	 */
	protected $creator;

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
	 * @var Points[]
	 *
	 * @ORM\OneToMany(targetEntity="models\entity\collection\Points", mappedBy="restaurants")
	 */
	private $points;

	/**
	 * @var Galleries[]
	 *
	 * @ORM\OneToMany(targetEntity="models\entity\restaurant\Galleries", mappedBy="restaurants")
	 */
	private $galleries;

	/**
	 * @var models\entity\member\Members[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\member\Members")
	 * @ORM\JoinTable(name="Restaurant_Like_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="restaurants_id", referencedColumnName="id", onDelete="CASCADE")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="members_id", referencedColumnName="id")}
	 * )
	 */
	protected $like;

	/**
	 * @var models\entity\member\Members[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\member\Members")
	 * @ORM\JoinTable(name="Restaurant_Dislike_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="restaurants_id", referencedColumnName="id", onDelete="CASCADE")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="members_id", referencedColumnName="id")}
	 * )
	 */
	protected $dislike;

	/**
	 * @var Comments[]
	 *
	 * @ORM\OneToMany(targetEntity="models\entity\restaurant\Comments", mappedBy="restaurant")
	 */
	protected $comments;

	/**
	 * Constructor, initial data
	 */
	public function __construct()
	{
		$this->features = array();
		$this->images = array();
		$this->tels = array();
		$this->emails = array();
		$this->hours = new Hours();
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
	public function onPrePersist()
	{
		$CI = get_instance();
		$CI->load->library('uuid');

		$this->uuid = $CI->uuid->v4();
		$this->createAt = new \DateTime('NOW', new \DateTimeZone('Asia/Taipei'));
		$this->createIP = $CI->input->server('REMOTE_ADDR');
	}

	/**
	 * @ORM\PreUpdate
	 */
	public function onPreUpdate()
	{
	}

	public function getId()
	{
		return $this->id;
	}

	public function getAddress()
	{
		return $this->address;
	}

	public function getFeatures()
	{
		return $this->features;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getUuid()
	{
		return $this->uuid;
	}

	public function getWebsite()
	{
		return $this->website;
	}

	/**
	 * Set address
	 *
	 * @param		string $address If this parameter is empty, then nothing to change.
	 */
	public function setAddress($address)
	{
		$this->address = Entity::preset($address, $this->address);
	}

	public function setFeatures($features)
	{
		$this->features = $features;
	}

	/**
	 * Set name
	 *
	 * @param		string $name If this parameter is empty, then nothing to change.
	 */
	public function setName($name)
	{
		$this->name = Entity::preset($name, $this->name);
	}

	/**
	 * Set website
	 *
	 * @param		string $name If this parameter is empty, then nothing to change.
	 */
	public function setWebsite($website)
	{
		$this->name = Entity::preset($website, $this->website);
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
