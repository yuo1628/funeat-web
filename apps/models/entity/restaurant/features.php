<?php

namespace models\entity\restaurant;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection as Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use models\entity\IEntity;

/**
 * Feature ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="features")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Features implements IEntity
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
	 * @Gedmo\TreeLeft
	 * @ORM\Column(name="lft", type="integer")
	 */
	private $lft;

	/**
	 * @Gedmo\TreeRight
	 * @ORM\Column(name="rgt", type="integer")
	 */
	private $rgt;

	/**
	 * @Gedmo\TreeLevel
	 * @ORM\Column(name="level", type="integer")
	 */
	private $level;

	/**
	 * @Gedmo\TreeRoot
	 * @ORM\Column(name="root", type="integer", nullable=true)
	 */
	private $root;

	/**
	 * @var Features
	 *
	 * @Gedmo\TreeParent
	 * @ORM\ManyToOne(targetEntity="Features", inversedBy="children")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	private $parent;

	/**
	 * @var Features[]
	 *
	 * @ORM\OneToMany(targetEntity="Features", mappedBy="parent")
	 * @ORM\OrderBy({"lft" = "ASC"})
	 */
	private $children;

	/**
	 * @var Restaurants[]
	 *
	 * @ORM\ManyToMany(targetEntity="Restaurants", mappedBy="features")
	 */
	private $restaurants;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, unique=true)
	 */
	private $title;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime")
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
	 * @ORM\Column(type="string")
	 */
	private $creator;

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

	/**
	 * @ORM\PrePersist
	 */
	public function doRegisterOnPrePersist()
	{
		$CI = get_instance();

		$this->createAt = new \DateTime('NOW', new \DateTimeZone('Asia/Taipei'));
		$this->createIP = $CI->input->server('REMOTE_ADDR');
		$this->creater = 0;
	}

	/**
	 * Return array
	 */
	public function toArray($recursion = false)
	{
		$return = get_object_vars($this);
		foreach ($return as $k => $v)
		{
			if ($k == 'parent')
			{
				if ($recursion && ( $v instanceof Features ) )
				{
					$return[$k] = $v->toArray();
				}
			}
			elseif ($v instanceof Collection)
			{
				if ($recursion)
				{
					$return[$k] = $v->toArray();

					foreach ($return[$k] as $k2 => $v2)
					{
						$return[$k][$k2] = $v2->toArray();
					}
				}
				else
				{
					unset($return[$k]);
				}
			}
		}

		return $return;
	}

	public function getChildren()
	{
		return $this->children;
	}

	public function getCreateAt()
	{
		return $this->createAt;
	}

	public function getCreateIP()
	{
		return $this->createIP;
	}

	public function getCreater()
	{
		return $this->creater;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getParent()
	{
		return $this->parent;
	}

	public function getRestaurants()
	{
		return $this->restaurants;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setCreater($v)
	{
		$this->creater = $v;
	}

	public function setParent(Features $v = null)
	{
		$this->parent = $v;
	}

	public function setRestaurants($v)
	{
		$this->restaurants = $v;
	}

	public function setTitle($v)
	{
		$this->title = $v;
	}

}
