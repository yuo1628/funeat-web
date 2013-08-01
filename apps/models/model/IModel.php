<?php

namespace models\model;

/**
 * Interface for my model
 *
 * @category		Models.Model
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
interface IModel
{
	/**
	 * Get total count
	 *
	 * @return integer
	 */
	public function getCount($condition = null);

	/**
	 * Get the error message
	 *
	 * @return void
	 */
	public function getError();

	/**
	 * Get empty instance.
	 *
	 * @return object
	 */
	public function getInstance();

	/**
	 * Get item
	 *
	 * @param mixed
	 * @param string
	 * @return this
	 */
	public function getItem($id, $column = null);

	/**
	 * Get items
	 *
	 * @return array
	 */
	public function getItems($condition = null);

	/**
	 * Get the messages
	 *
	 * @return void
	 */
	public function getMessage();

	/**
	 * Set an error message
	 *
	 * @return void
	 */
	public function setError($error);

	/**
	 * Set group value for $this->db->group_by()
	 *
	 * @param string or array
	 * @return this
	 */
	public function setGroupBy($by);

	/**
	 * Set search function for $this->db->like
	 *
	 * @param mixed
	 * @param string
	 * @return this
	 */
	public function setLike($like, $value = null);

	/**
	 * Set limit for $this->db->limit
	 *
	 * @param int
	 * @return this
	 */
	public function setLimit($limit);

	/**
	 * Set a message
	 *
	 * @return void
	 */
	public function setMessage($message);

	/**
	 * Set offset for $this->db->limit
	 *
	 * @param int
	 * @return this
	 */
	public function setOffset($offset);

	/**
	 * set order value for $this->db->order
	 *
	 * @param string
	 * @param string
	 * @return this
	 */
	public function setOrderBy($by, $order = 'desc');

	/**
	 * Set where for $this->db->where
	 *
	 * @param mixed
	 * @param string
	 * @return this
	 */
	public function setWhere($where, $value = null);

	/**
	 * Save Data API
	 *
	 * @param object
	 * @return int
	 */
	public function save($entity);

	/**
	 * Remove Data API
	 *
	 * @param object
	 */
	public function remove($entity);
}
