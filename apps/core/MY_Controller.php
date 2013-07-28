<?php defined('BASEPATH') or die('No direct script access allowed');

/**
 * Add layout function.
 *
 * @author		Miles <jangconan@gmail.com>
 */
class MY_Controller extends CI_Controller
{
	/**
	 * Use to switch the database auto update
	 *
	 * @var			boolean
	 */
	const AUTO_UPDATE = false;

	/**
	 * Output type constants
	 */
	const OUTPUT_FORMAT = 'format';
	const OUTPUT_FORMAT_HTML = 'html';
	const OUTPUT_FORMAT_JSON = 'json';
	const OUTPUT_FORMAT_RSS = 'rss';

	/**
	 * Entities, use for create database schema.
	 *
	 * @var			array
	 */
	protected $_entity = array(
		'models\\entity\\collection\\Collections',
		'models\\entity\\collection\\Points',
		'models\\entity\\collection\\Templates',
		'models\\entity\\restaurant\\Comments',
		'models\\entity\\restaurant\\Cuisines',
		'models\\entity\\restaurant\\Features',
		'models\\entity\\restaurant\\Restaurants',
		'models\\entity\\image\\Images',
		'models\\entity\\member\\Comments',
		'models\\entity\\member\\Members',
		'models\\entity\\member\\Membergroups'
	);

	/**
	 * Data will set in view
	 *
	 * @var			Head
	 */
	public $head;

	/**
	 * Data will set in view
	 *
	 * @var			stdClass
	 */
	protected $_blocks;

	/**
	 * Data will set in view
	 *
	 * @var			array
	 */
	protected $_data;

	/**
	 * Main layout
	 *
	 * @var			string
	 */
	protected $_layout;

	/**
	 * Constructor
	 *
	 * @param		string Default layout
	 */
	public function __construct($layout)
	{
		parent::__construct();

		// Load library
		$this->load->library('Head');

		$this->_blocks = new stdClass();
		$this->_data = array();
		$this->_layout = $layout;

		if (ENVIRONMENT == 'development' && self::AUTO_UPDATE)
		{
			$this->updateSchema();
		}
	}

	/**
	 * Update database
	 */
	private function updateSchema()
	{
		$this->load->library('doctrine');
		$entity = array();

		foreach ($this->_entity as $value)
		{
			$entity[] = $this->doctrine->em->getClassMetadata($value);
		}

		$this->doctrine->tool->updateSchema($entity);
	}

	/**
	 * Get blocks data.
	 *
	 * @param		mixed The blocks array key
	 *
	 * @return		mixed
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
	 * @param		mixed The data array key
	 *
	 * @return		mixed
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
	 * @return		string
	 */
	public function getLayout()
	{
		return $this->_layout;
	}

	/**
	 * Set blocks data.
	 *
	 * @param		mixed The block array key
	 * @param		mixed Value
	 *
	 * @return		void
	 */
	public function setBlock($property, $value)
	{
		$this->_blocks->$property = $value;
	}

	/**
	 * Set view data.
	 *
	 * @param		mixed The data array key
	 * @param		mixed Value
	 *
	 * @return		void
	 */
	public function setData($key, $value)
	{
		$this->_data[$key] = $value;
	}

	/**
	 * Set layout.
	 *
	 * @param		string
	 *
	 * @return		void
	 */
	public function setLayout($layout)
	{
		$this->_layout = $layout;
	}

	/**
	 * Do $this->load->view use layout.
	 *
	 * @param		string
	 * @param		boolean
	 *
	 * @return		mixed
	 */
	public function view($view = null, $return = false)
	{
		$this->_data['head'] = $this->head;

		if (!is_null($view))
		{
			$this->_blocks->body = $view;
		}
		$this->setData('blocks', $this->_blocks);
		$this->load->view($this->_layout, $this->_data, $return);
	}

}
