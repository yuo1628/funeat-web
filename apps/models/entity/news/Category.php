<?php

namespace models\entity\news;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use models\entity\Entity;

/**
 * Category ORM class
 *
 * @category		Models.Entity
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 *
 * @ORM\Entity
 * @ORM\Table(name="news_categorys")
 */
class Category extends Entity
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
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @var News[]
	 *
	 * @ORM\OneToMany(targetEntity="News", mappedBy="category")
	 */
	private $news;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->news = new ArrayCollection();
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

	public function setName($value)
	{
		$this->name = $value;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getNews()
	{
		return $this->news;
	}

}
