<?php

namespace models\model;

/**
 * ORM Model parent class
 *
 * @category		Models.Model
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class ORMModel extends Model
{
	/**
	 * @access protected
	 * @var mix
	 */
	protected $_instance;

	/**
	 * @access protected
	 * @var String
	 */
	protected $_entity;

	/**
	 * @access protected
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $_em;

	/**
	 * @access protected
	 * @var Doctrine\ORM\EntityRepository
	 */
	protected $_repository;

	/**
	 * Constructor.
	 */
	public function __construct($entity)
	{
		parent::__construct();

		$this->_entity = $entity;
		$this->_em =  get_instance()->doctrine->em;
		$this->_repository = $this->_em->getRepository($entity);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getInstance()
	{
		$entity = $this->_entity;

		if ($this->_instance == null)
		{
			$this->_instance = new $entity();
		}
		return clone $this->_instance;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getItem($id, $column = null)
	{
		if ($column === null)
		{
			return $this->_repository->find($id);
		}
		else
		{
			return $this->_repository->findBy(array($column => $id));
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getItems()
	{
		return $this->_repository->findAll();
	}

	/**
	 * {@inheritDoc}
	 */
	public function save($entity)
	{
		if ($entity instanceof $this->_entity)
		{
			$meta = $this->_em->getClassMetadata(get_class($entity));
			$identifier = $meta->getSingleIdentifierFieldName();
			$funcName = 'get' . ucfirst($identifier);

			// TODO: use the entity primary key.
			if ($entity->$funcName() === null)
			{
				$this->_em->persist($entity);
			}
			else
			{
				$this->_em->merge($entity);
			}
			$this->_em->flush();
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function remove($entity)
	{
		if ($entity instanceof $this->_entity)
		{
			$this->_em->remove($entity);
			$this->_em->flush();
		}
	}

}
