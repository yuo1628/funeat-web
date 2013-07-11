<?php

namespace blog\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $title;

		/**
     * @ORM\Column(type="integer", length=2)
     */
    private $visits;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

	public function title($value = NULL)
	{
		if (is_null($value))
			return $this->title;
		else
			$this->title = $value;
	}

	public function content($value = NULL)
	{
		if (is_null($value))
			return $this->content;
		else
			$this->content = $value;
	}

	public function visits($value = NULL)
	{
		if (is_null($value))
			return $this->visits;
		else
			$this->visits = $value;
	}

	public function addVisit() { $this->visits++; }

}

/* End of file Post.php */
/* Location: ./application/modules/blog/modules/Post.php */