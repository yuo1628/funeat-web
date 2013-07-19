<?php

namespace models\model;

/**
 * ORM Model parent class
 *
 * @category		Models.Model
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class CIModel extends Model
{
	/**
	 * Holds an array of tables used
	 *
	 * @param string
	 */
	protected $_table;

	/**
	 * table primary key
	 *
	 * @var string
	 */
	protected $_key;

	/**
	 * Response
	 *
	 * @var string
	 */
	protected $_response;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct($tables, $key)
	{
		parent::__construct();

		$this->_table = $table;
		$this->_key = $key;
		$this->_response = null;
	}

	/*
	 * Insert Data API
	 *
	 * @param array
	 * @return int
	 */
	protected function insert($data = null)
	{
		$external_data = array('add_time' => $this->_time, 'edit_time' => $this->_time);

		// merge array data
		$data = array_merge($data, $external_data);
		// insert to database
		$this->db->insert($this->tables['master'], $data);

		return $this->db->insert_id();
	}

	/**
	 * Update Data API
	 *
	 * @param  mixed
	 * @param  array
	 * @return bool
	 */
	protected function update($id, $data = null)
	{
		if (is_array($id))
		{
			$this->db->where_in($this->_key, $id);
		}
		else
		{
			$this->db->where($this->_key, $id);
		}

		$external_data = array('edit_time' => $this->_time);

		$data = array_merge($data, $external_data);

		if (isset($data[$this->_key]))
		{
			unset($data[$this->_key]);
		}

		$result = $this->db->set($data)->update($this->tables['master']);

		return $result;
	}

	/**
	 * Delete Data API
	 *
	 * @param  mixed
	 * @return bool
	 */
	protected function delete($id)
	{
		if (is_array($id))
		{
			$this->db->where_in($this->_key, $id);
		}
		else
		{
			$this->db->where($this->_key, $id);
		}

		if ($this->soft_delete)
		{
			$data = array($this->soft_delete_key => 1, "edit_time" => $this->_time, );

			// update soft delete key
			$result = $this->db->update($this->tables['master'], $data);
		}
		else
		{
			// delete row
			$result = $this->db->delete($this->tables['master']);
		}

		return $result;
	}

	/**
	 * get rows array data
	 *
	 * @return void
	 */
	protected function handle_process()
	{
		//set select field
		if (isset($this->_select))
		{
			foreach ($this->_select as $select)
			{
				$this->db->select($select, false);
			}

			$this->_select = array();
		}

		//run each where that was passed
		if (isset($this->_where))
		{
			foreach ($this->_where as $k => $v)
			{
				if (is_array($v))
				{
					$this->db->where_in($k, $v);
				}
				else
				{
					if ($v == null)
					{
						$this->db->where($k, $v, false);
					}
					else
					{
						$this->db->where($k, $v);
					}
				}
			}

			$this->_where = array();
		}

		//run each like that was passed
		if (isset($this->_like))
		{
			foreach ($this->_like as $like)
			{
				$this->db->like($like);
			}

			$this->_like = array();
		}

		//set limit and offset
		if (isset($this->_limit) && isset($this->_offset))
		{
			$this->db->limit($this->_limit, $this->_offset);

			$this->_limit = null;
			$this->_offset = null;
		}

		//set limit
		if (isset($this->_limit))
		{
			$this->db->limit($this->_limit);

			$this->_limit = null;
		}

		//set the order
		if (isset($this->_order_by) && isset($this->_order))
		{
			$this->db->order_by($this->_order_by, $this->_order);

			$this->_order = null;
			$this->_order_by = null;
		}

		//set the order field
		if (isset($this->_order_by_field))
		{
			$this->db->order_by($this->_order_by_field);

			$this->_order_by_field = null;
		}

		//set the group field
		if (isset($this->_group_by))
		{
			$this->db->group_by($this->_group_by);

			$this->_group_by = null;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getInstance()
	{
		// TODO: Implement it!
	}

	/**
	 * {@inheritDoc}
	 */
	public function getItem($id = null)
	{
		// TODO: Implement it!
	}

	/**
	 * {@inheritDoc}
	 */
	public function getItems()
	{
		// TODO: Implement it!
	}

	/**
	 * {@inheritDoc}
	 */
	public function save($target)
	{
		// TODO: Implement it!
	}

	/**
	 * {@inheritDoc}
	 */
	public function remove($target)
	{
		// TODO: Implement it!
	}

}
