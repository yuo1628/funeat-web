<?php

namespace models\entity\notification;

use Doctrine\ORM\Mapping as ORM;

use models\FuneatFactory;
use models\entity\Entity;
use models\entity\member\Members as Members;

/**
 * Notifications ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="notifications")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Notifications extends Entity
{
	/**
	 * The constants for query by columns.
	 *
	 * @var string
	 */
	const COLUMN_ID = 'id';
	const COLUMN_UUID = 'uuid';

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
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime", length=32)
	 */
	protected $createAt;

	/**
	 * @var models\entity\notification\Type
	 *
	 * @ORM\ManyToOne(targetEntity="models\entity\notification\Type", inversedBy="notifications")
	 */
	protected $type;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="smallint")
	 */
	protected $public;

	/**
	 * @var models\entity\member\Membergroups[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\member\Membergroups")
	 * @ORM\JoinTable(name="Notifications_Membergroup_Readable_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="notifications_id", referencedColumnName="id", onDelete="CASCADE")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="membergroups_id", referencedColumnName="id")}
	 * )
	 */
	protected $readableMembergroups;

	/**
	 * @var models\entity\member\Members[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\member\Members")
	 * @ORM\JoinTable(name="Notifications_Member_Readable_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="notifications_id", referencedColumnName="id", onDelete="CASCADE")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="members_id", referencedColumnName="id")}
	 * )
	 */
	protected $readableMembers;

	/**
	 * @var models\entity\member\Members[]
	 *
	 * @ORM\ManyToMany(targetEntity="models\entity\member\Members")
	 * @ORM\JoinTable(name="Notifications_Member_Read_Mapping",
	 * 	joinColumns={@ORM\JoinColumn(name="notifications_id", referencedColumnName="id", onDelete="CASCADE")},
	 * 	inverseJoinColumns={@ORM\JoinColumn(name="members_id", referencedColumnName="id")}
	 * )
	 */
	protected $read;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->public = 1;
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

	public function __get($key)
	{
		return $this->$key;
	}

	public function __set($key, $value)
	{
		$this->$key = $value;
	}

}
