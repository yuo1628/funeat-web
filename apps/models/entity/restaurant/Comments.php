<?php

namespace models\entity\restaurant;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use models\FuneatFactory;
use models\entity\Entity;
use models\entity\restaurant\Restaurants as Restaurants;

/**
 * Comments ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="restaurant_comments")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Comments extends Entity
{
	/**
	 * The constants for query by columns.
	 *
	 * @var string
	 */
	const COLUMN_ID = 'id';
	const COLUMN_UUID = 'uuid';

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
	 * @ORM\ManyToOne(targetEntity="Comments", inversedBy="replies")
	 * @ORM\JoinColumn(name="reply_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $reply;

	/**
	 * @var Restaurants[]
	 *
	 * @ORM\OneToMany(targetEntity="Comments", mappedBy="reply")
	 * @ORM\OrderBy({"lft" = "ASC"})
	 */
	protected $replies;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $type;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime")
	 */
	protected $createAt;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=15)
	 */
	protected $createIP;

	/**
	 * @var models\entity\member\Members
	 *
	 * @ORM\ManyToOne(targetEntity="models\entity\member\Members", inversedBy="comments")
	 */
	protected $creator;

	/**
	 * @var models\entity\restaurant\Restaurants
	 *
	 * @ORM\ManyToOne(targetEntity="models\entity\restaurant\Restaurants", inversedBy="comments")
	 */
	protected $restaurant;

	/**
	 * @var models\entity\member\Members[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\member\Members")
	 * @ORM\JoinTable(name="Restaurant_Comments_Like_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="comments_id", referencedColumnName="id", onDelete="CASCADE")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="members_id", referencedColumnName="id")}
	 * )
	 */
	protected $like;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	protected $comment;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="smallint")
	 */
	protected $deleted;

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
		$this->creator = FuneatFactory::getMember();
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

	public function getUuid()
	{
		return $this->uuid;
	}

	public function getLike()
	{
		return $this->like;
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

	public function getDeleted()
	{
		return $this->deleted;
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

	public function setComment($comment)
	{
		$this->comment = trim($comment);
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

	public function setDeleted($deleted)
	{
		$this->deleted = $deleted;
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
