<?php

namespace models\entity\notification;

use Doctrine\ORM\Mapping as ORM;

use models\FuneatFactory;
use models\ModelFactory;
use models\notification\Params;
use models\notification\Action as Action;
use models\entity\Entity;
use models\entity\member\Members as Members;
use models\entity\notification\Type as Type;

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
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	protected $message;

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
	public function onPrePersist()
	{
		$CI = get_instance();
		$CI->load->library('uuid');

		$this->uuid = $CI->uuid->v4();
		$this->createAt = new \DateTime('NOW', new \DateTimeZone('Asia/Taipei'));
	}

	/**
	 * @ORM\PostLoad
	 */
	public function onPostLoad()
	{
		$this->message = $this->type->getTemplate();
	}

	public function getCreateAt()
	{
		return $this->createAt;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function getPublic()
	{
		return $this->public;
	}

	/**
	 * @return models\entity\member\Membergroups[]
	 */
	public function getReadableMembergroups()
	{
		return $this->readableMembergroups;
	}

	/**
	 * @return models\entity\member\Members[]
	 */
	public function getReadableMembers()
	{
		return $this->readableMembers;
	}

	/**
	 * @return models\entity\member\Members[]
	 */
	public function getRead()
	{
		return $this->read;
	}

	/**
	 * @return models\entity\notification\Type
	 */
	public function getType()
	{
		return $this->type;
	}

	public function getUuid()
	{
		return $this->uuid;
	}

	public function setMessage($action, $params = array())
	{
		$this->message = Action::buildMessage($action, $params);
	}

	public function setPublic($public = true)
	{
		if ($public)
		{
			$this->public = 1;
		}
		else
		{
			$this->public = 0;
		}
	}

	/**
	 * @param string
	 */
	public function setType($const)
	{
		if (in_array($const, Action::getActions()))
		{
			$typeModel = ModelFactory::getInstance('models\\notification\\Type');
			$type = $typeModel->getItem($const, 'action');

			if ($type === null)
			{
				$type = $typeModel->getInstance();
				$type->setAction($const);
				$type->setTemplate($const);
				$typeModel->save($type);
			}
			$this->type = $type;
		}
	}

}
