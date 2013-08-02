<?php

namespace models\entity\image;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection as Collection;

use models\FuneatFactory;
use models\entity\Entity as Entity;
use models\entity\member\Members as Members;

/**
 * Images ORM Class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Table(name="images")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Images extends Entity
{
	/**
	 * Gallery type
	 *
	 * @var integer
	 */
	const UPLOAD_PATH = 'upload/';

	/**
	 * Upload path
	 *
	 * @var string
	 */
	public static $UPLOAD_CONFIG = array(
		'upload_path' => self::UPLOAD_PATH,
		'allowed_types' => 'gif|jpg|png',
		'encrypt_name' => true
	);

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
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	protected $origin;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=50, unique=true)
	 */
	protected $filename;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $title;

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
	 * @ORM\ManyToOne(targetEntity="models\entity\member\Members", inversedBy="images")
	 */
	protected $creator;

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
	public function doPrePersist()
	{
		$CI = get_instance();
		$CI->load->library('uuid');

		$this->uuid = $CI->uuid->v4();
		$this->createAt = new \DateTime('NOW', new \DateTimeZone('Asia/Taipei'));
		$this->createIP = $CI->input->server('REMOTE_ADDR');
		$this->creator = FuneatFactory::getMember();
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

	public function getFilename()
	{
		return $this->filename;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getOrigin()
	{
		return $this->origin;
	}

	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set creator
	 *
	 * @param		Members $creator
	 */
	public function setCreater(Members $creator)
	{
		$this->creator = $creator;
	}

	/**
	 * Set file into database
	 *
	 * @param		string $origin
	 * @param		string $filename
	 * @param		int $type
	 */
	public function setFile($origin, $filename)
	{
		$this->origin = Entity::preset($origin, $this->origin);
		$this->filename = Entity::preset($filename, $this->filename);
	}

	public function setTitle($title)
	{
		$this->title = Entity::preset($title, $this->title);
	}

}
