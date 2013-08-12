<?php

namespace models\entity\restaurant;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection as Collection;
use Gedmo\Mapping\Annotation as Gedmo;

use models\FuneatFactory;
use models\ModelFactory;
use models\Feature as Feature;
use models\entity\Entity as Entity;
use models\restaurant\Hours;
use models\entity\image\Images as Images;
use models\notification\Action as Action;
use Maps;

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
	 * @var models\entity\image\Images
	 *
	 * @ORM\OneToOne(targetEntity="models\entity\image\Images", cascade={"persist", "remove"})
	 */
	protected $logo;

	/**
	 * @var models\entity\image\Images[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\image\Images", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="Restaurant_Images_Gallery",
	 * 	joinColumns={@ORM\JoinColumn(name="restaurants_id", referencedColumnName="id", onDelete="CASCADE")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="images_id", referencedColumnName="id")}
	 * )
	 */
	protected $gallery;

	/**
	 * @var models\entity\image\Images[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\image\Images", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="Restaurant_Images_Menu",
	 * 	joinColumns={@ORM\JoinColumn(name="restaurants_id", referencedColumnName="id", onDelete="CASCADE")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="images_id", referencedColumnName="id")}
	 * )
	 */
	protected $menu;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	protected $address;

	/**
	 * @var float
	 *
	 * @ORM\Column(type="float")
	 */
	protected $latitude;

	/**
	 * @var float
	 *
	 * @ORM\Column(type="float")
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
	 * @var models\entity\member\Members[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\member\Members")
	 * @ORM\JoinTable(name="Restaurant_Member_Subscription",
	 * 	joinColumns={@ORM\JoinColumn(name="restaurants_id", referencedColumnName="id", onDelete="CASCADE")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="members_id", referencedColumnName="id")}
	 * )
	 */
	protected $subscription;

	/**
	 * Distance
	 *
	 * @var float
	 */
	protected $distance;

	/**
	 * Constructor, initial data
	 */
	public function __construct()
	{
		$this->features = array();
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
		$CI->load->library('Maps');

		$this->uuid = $CI->uuid->v4();
		$this->createAt = new \DateTime('NOW', new \DateTimeZone('Asia/Taipei'));
		$this->createIP = $CI->input->server('REMOTE_ADDR');
		$this->creator = FuneatFactory::getMember();
	}

	/**
	 * @ORM\PostPersist
	 */
	public function onPostPersist()
	{
		$notificationModel = ModelFactory::getInstance('models\Notification');

		/**
		 * @var models\entity\notification\Notifications
		 */
		$notification = $notificationModel->getInstance();
		$notification->setType(Action::RESTAURANT_ADD);
		$notification->setMessage(Action::RESTAURANT_ADD);
		$notification->setPublic(true);

		$notificationModel->save($notification);
	}

	/**
	 * @ORM\PostUpdate
	 */
	public function onPostUpdate()
	{
		$notificationModel = ModelFactory::getInstance('models\Notification');

		/**
		 * @var models\entity\notification\Notifications
		 */
		$notification = $notificationModel->getInstance();
		$notification->setType(Action::RESTAURANT_EDIT);
		$notification->setMessage(Action::RESTAURANT_EDIT);
		$notification->setPublic(true);

		$notificationModel->save($notification);
	}

	public function getId()
	{
		return $this->id;
	}

	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * @return		\models\entity\restaurant\Comments[]
	 */
	public function getComments()
	{
		return $this->comments;
	}

	/**
	 * Get dislike collection
	 *
	 * @return		\models\entity\member\Members[]
	 */
	public function getDislike()
	{
		return $this->dislike;
	}

	/**
	 * Get distance
	 *
	 * @return		float
	 */
	public function getDistance()
	{
		return $this->distance;
	}

	public function getFax()
	{
		return $this->fax;
	}

	public function getFeatures()
	{
		return $this->features;
	}

	/**
	 * Get gallery
	 *
	 * @return		\models\entity\image\Images[]
	 */
	public function getGallery()
	{
		return $this->gallery;
	}

	public function getIntro()
	{
		return $this->intro;
	}

	public function getLatitude()
	{
		return $this->latitude;
	}

	/**
	 * Get like collection
	 *
	 * @return		\models\entity\member\Members[]
	 */
	public function getLike()
	{
		return $this->like;
	}

	/**
	 * Get logo
	 *
	 * @return		\models\entity\image\Images
	 */
	public function getLogo()
	{
		return $this->logo;
	}

	public function getLongitude()
	{
		return $this->longitude;
	}

	/**
	 * Get menu
	 *
	 * @return		models\entity\image\Images[]
	 */
	public function getMenu()
	{
		return $this->menu;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getPriceHigh()
	{
		return $this->priceHigh;
	}

	public function getPriceLow()
	{
		return $this->priceLow;
	}

	public function getTel()
	{
		return $this->tel;
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

	/**
	 * Set distance
	 *
	 * @param		float $lat
	 * @param		float $lng
	 */
	public function setDistance($lat, $lng = null)
	{
		if ($lng === null)
		{
			$this->distance = $lat;
		}
		else
		{
			$this->distance = Maps::getDistance($lat, $lng, $this->getLatitude(), $this->getLongitude());
		}
	}

	/**
	 * Set Email
	 *
	 * @param		string $email If this parameter is empty, then nothing to change.
	 */
	public function setEmail($email)
	{
		$this->email = Entity::preset($email, $this->email);
	}

	/**
	 * Set fax
	 *
	 * @param		string $name If this parameter is empty, then nothing to change.
	 */
	public function setFax($fax)
	{
		$this->fax = Entity::preset($fax, $this->fax);
	}

	/**
	 * Set features
	 *
	 * @param		array $features checkbox array. If this parameter is empty, then nothing to change.
	 * @param		\models\Feature $model Feature model.
	 */
	public function setFeatures($features, Feature $model)
	{
		if (is_array($features) && !empty($features))
		{
			$featuresData = array();

			foreach ($features as $v)
			{
				$featuresData[] = $model->getItem((int)$v);
			}

			$this->features = $featuresData;
		}
	}

	/**
	 * Set gallery
	 *
	 * @param		\models\entity\image\Images[] $images
	 */
	public function setGallery($gallery)
	{
		$this->gallery = !empty($gallery) ? $gallery : null;
	}

	/**
	 * Set latitude and longitude
	 *
	 * @param		float $lat Latitude of the position.
	 * @param		float $lng Longitude of the position.
	 */
	public function setLatLng($lat, $lng)
	{
		$this->latitude = (float)$lat;
		$this->longitude = (float)$lng;
	}

	/**
	 * Set logo
	 *
	 * @param		\models\entity\image\Images $logo
	 */
	public function setLogo($logo)
	{
		$this->logo = ($logo instanceof Images) ? $logo : null;
	}

	/**
	 * Set menu
	 *
	 * @param		\models\entity\image\Images[] $menu
	 */
	public function setMenu($menu)
	{
		$this->menu = !empty($menu) ? $menu : null;
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
	 * Set higher price
	 *
	 * @param		string $priceHigh If this parameter is empty, then nothing to change.
	 */
	public function setPriceHigh($priceHigh)
	{
		$this->priceHigh = Entity::preset($priceHigh, $this->priceHigh);
	}

	/**
	 * Set lower price
	 *
	 * @param		string $priceLow If this parameter is empty, then nothing to change.
	 */
	public function setPriceLow($priceLow)
	{
		$this->priceLow = Entity::preset($priceLow, $this->priceLow);
	}

	/**
	 * Set telephone
	 *
	 * @param		string $tel If this parameter is empty, then nothing to change.
	 */
	public function setTel($tel)
	{
		$this->tel = Entity::preset($tel, $this->tel);
	}

	/**
	 * Set website
	 *
	 * @param		string $website If this parameter is empty, then nothing to change.
	 */
	public function setWebsite($website)
	{
		$this->website = Entity::preset($website, $this->website);
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
