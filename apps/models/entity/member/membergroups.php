<?php

namespace models\entity\member;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Membergroups ORM class
 *
 * Use Gedmo nested tree sample.
 * Use repository for handy tree functions.
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="membergroups")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 */
class Membergroups
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	private $id;

	/**
	 * @var integer
	 *
	 * @Gedmo\TreeLeft
	 * @ORM\Column(name="lft", type="integer")
	 */
	private $lft;

	/**
	 * @var integer
	 *
	 * @Gedmo\TreeRight
	 * @ORM\Column(name="rgt", type="integer")
	 */
	private $rgt;

	/**
	 * @var integer
	 *
	 * @Gedmo\TreeLevel
	 * @ORM\Column(name="level", type="integer")
	 */
	private $level;

	/**
	 * @var integer/NULL
	 *
	 * @Gedmo\TreeRoot
	 * @ORM\Column(name="root", type="integer", nullable=true)
	 */
	private $root;

	/**
	 * @var Membergroups
	 *
	 * @Gedmo\TreeParent
	 * @ORM\ManyToOne(targetEntity="Membergroups", inversedBy="children")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	private $parent;

	/**
	 * @var Membergroups[]
	 *
	 * @ORM\OneToMany(targetEntity="Membergroups", mappedBy="parent")
	 * @ORM\OrderBy({"lft" = "ASC"})
	 */
	private $children;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="string", length=255)
	 */
	private $title;

	/**
	 * @var Members[]
	 *
	 * @ORM\ManyToMany(targetEntity="Members", mappedBy="membergroups")
	 */
	private $members;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->members = new ArrayCollection();
	}

	/**
	 * Clone
	 */
	public function __clone()
	{
	}

	public function getId()
	{
		return $this->id;
	}

	public function setParent(Membergroups $value = null)
	{
		$this->parent = $value;
	}

	public function getParent()
	{
		return $this->parent;
	}

	public function setTitle($value)
	{
		$this->title = $value;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getMembers()
	{
		return $this->members;
	}

}
