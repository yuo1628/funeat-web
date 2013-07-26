<?php

namespace models\entity\restaurant;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use models\entity\IEntity;
use models\entity\restaurant\Restaurants as Restaurants;

/**
 * Comments ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Comments implements IEntity
{
	/**
	 * Type constants
	 */
	const TYPE_GUEST = 0;
	const TYPE_MEMBER = 1;
	const TYPE_RESTAURANT = 2;
	const TYPE_ADMIN = 2;

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
	 * @ORM\Column(type="string", length=36, unique=true)
	 */
	private $uuid;

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
	 * @var Restaurants
	 *
	 * @Gedmo\TreeParent
	 * @ORM\ManyToOne(targetEntity="Comments", inversedBy="replies")
	 * @ORM\JoinColumn(name="reply_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	private $reply;

	/**
	 * @var Restaurants[]
	 *
	 * @ORM\OneToMany(targetEntity="Comments", mappedBy="reply")
	 * @ORM\OrderBy({"lft" = "ASC"})
	 */
	private $replies;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="integer")
	 */
	private $type;

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
	 * @var string
	 *
	 * @ORM\Column(type="string")
	 */
	private $creator;

	/**
	 * @var models\entity\restaurant\Restaurants
	 *
	 * @ORM\ManyToOne(targetEntity="models\entity\restaurant\Restaurants", inversedBy="comments")
	 */
	private $restaurant;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	private $comment;

	/**
	 * Constructor
	 */
	public function __construct()
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
	 * Cloneable
	 */
	public function __clone()
	{
	}

	/**
	 * Return array
	 *
	 * @return		array
	 */
	public function toArray($recursion = false)
	{
		$return = get_object_vars($this);
		foreach ($return as $k => $v)
		{
			if ($v instanceof Collection)
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

	public function getId()
	{
		return $this->id;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getComment()
	{
		return $this->comment;
	}

	public function getCreator()
	{
		return $this->creator;
	}

	public function getRestaurant()
	{
		return $this->restaurant;
	}

	public function getReply()
	{
		return $this->reply;
	}

	public function getReplies()
	{
		return $this->replies;
	}

	public function setComment($v)
	{
		$this->comment = $v;
	}

	/**
	 * Set creator
	 *
	 * @param		creator
	 * @param		type
	 */
	public function setCreator($creator, $type)
	{
		switch ($type)
		{
			case self::TYPE_ADMIN :
				$this->type = $type;
				$this->creator = $creator->getId();
				break;
			case self::TYPE_GUEST :
				$this->type = $type;
				$this->creator = empty($creator) ? 'Guest ' : $creator;
				break;
			case self::TYPE_MEMBER :
				$this->type = $type;
				$this->creator = $creator->getId();
				break;
			case self::TYPE_RESTAURANT :
				$this->type = $type;
				$this->creator = $creator->getId();
				break;
		}
	}

	public function setRestaurant(Restaurants $v)
	{
		$this->restaurant = $v;
	}

	public function setReply(Comments $v)
	{
		$this->reply = $v;
	}

}
