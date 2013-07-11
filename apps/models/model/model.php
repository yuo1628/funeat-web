<?php

namespace models\model;

/**
 * Abstract for my model
 *
 * @category		Models.Model
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
abstract class Model implements IModel
{
    /**
     * Error
	 *
	 * @var array
     **/
    protected $_error;

    /**
     * Group By
	 *
	 * @var string
     */
    protected $_group_by;

    /**
     * Like
	 *
	 * @var array
     */
    protected $_like;

    /**
     * Limit
	 *
	 * @var integer
     */
    protected $_limit;

    /**
     * Message
	 *
	 * @var array
     **/
    protected $_message;

    /**
     * Offset
	 *
	 * @var integer
     */
    protected $_offset;

    /**
     * Order
	 *
	 * @var string
     */
    protected $_order;

    /**
     * Order By
	 *
	 * @var string
     */
    protected $_order_by;

    /**
     * Select
	 *
	 * @var array
     */
    protected $_select;

    /**
     * Where
	 *
	 * @var array
     */
    protected $_where;

    /**
     * __construct
     */
    public function __construct()
    {
		$this->_error = array();
		$this->_like = array();
		$this->_message = array();
		$this->_select = array();
		$this->_where = array();
    }

    /**
     * {@inheritDoc}
     */
    public function getError()
    {
        $output = '';
        foreach ($this->_error as $error) {
            $output .= ((empty($_output)) ? '' : ', ') . $error;
        }

        return $output;
    }

    /**
     * {@inheritDoc}
     */
    public function getMessage()
    {
        $output = '';
        foreach ($this->_message as $message) {
            $output .= ((empty($output)) ? '' : ', ') . $message;
        }

        return $output;
    }

    /**
     * {@inheritDoc}
     */
    public function setColumn($select)
    {
        $this->_select[] = $select;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setError($error)
    {
        $this->_error[] = $error;
    }

    /**
     * {@inheritDoc}
     */
    public function setGroupBy($by)
    {
        $this->_group_by = $by;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setLike($like, $value = null)
    {
        if (!is_array($like)) {
            $like = array($like => $value);
        }

		$this->_like[] = $like;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setLimit($limit)
    {
        $this->_limit = (int) $limit;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setMessage($message)
    {
        $this->_message[] = $message;
    }

    /**
     * {@inheritDoc}
     */
    public function setOffset($offset)
    {
        $this->_offset = (int) $offset;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setOrderBy($by, $order = 'desc')
    {
        $this->_order_by = $by;
        $this->_order    = $order;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setWhere($where, $value = null)
    {
        if (is_array($where))
		{
            foreach ($where as $k => $v)
            {
                $this->_where[$k] = $v;
            }
        } else {
            $this->_where[$where] = $value;
        }

        return $this;
    }
}
