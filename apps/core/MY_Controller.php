<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Add layout function.
 *
 * @author		Miles <jangconan@gmail.com>
 */
class MY_Controller extends CI_Controller
{
	/**
	 * Data will set in view
	 *
	 * @var object
	 */
	protected $_blocks;

	/**
	 * Data will set in view
	 *
	 * @var array
	 */
	protected $_data;

	/**
	 * Main layout
	 *
	 * @var string
	 */
	protected $_layout;

	/**
	 * Constructor
	 *
	 * @param string Default layout
	 */
	public function __construct($layout)
	{
		parent::__construct();

		$this->_blocks = new stdClass();
		$this->_data = array();
		$this->_layout = $layout;
	}

	/**
	 * Get blocks data.
	 *
	 * @param mixed The blocks array key
	 *
	 * @return mixed
	 */
	public function getBlock($property = null)
	{
		if (is_null($key))
		{
			return $this->_blocks;
		}
		else
		{
			return $this->_blocks->$property;
		}
	}

	/**
	 * Get view data.
	 *
	 * @param mixed The data array key
	 *
	 * @return mixed
	 */
	public function getData($key = null)
	{
		if (is_null($key))
		{
			return $this->_data;
		}
		else
		{
			return $this->_data[$key];
		}
	}

	/**
	 * Get layout.
	 *
	 * @return string
	 */
	public function getLayout()
	{
		return $this->_layout;
	}

	/**
	 * Set blocks data.
	 *
	 * @param mixed The block array key
	 * @param mixed Value
	 *
	 * @return void
	 */
	public function setBlock($property, $value)
	{
		$this->_blocks->$property = $value;
	}


	/**
	 * Set view data.
	 *
	 * @param mixed The data array key
	 * @param mixed Value
	 *
	 * @return void
	 */
	public function setData($key, $value)
	{
		$this->_data[$key] = $value;
	}

	/**
	 * Set layout.
	 *
	 * @param string
	 *
	 * @return void
	 */
	public function setLayout($layout)
	{
		$this->_layout = $layout;
	}

	/**
	 * Do $this->load->view use layout.
	 *
	 * @param string
	 * @param boolean
	 *
	 * @return mixed
	 */
	public function view($view = null, $return = false)
	{
		if (!is_null($view))
		{
			$this->_blocks->body = $view;
		}
		$this->setData('blocks', $this->_blocks);
		$this->load->view($this->_layout, $this->_data, $return);
	}
}
