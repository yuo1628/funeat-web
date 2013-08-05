<?php defined('BASEPATH') or exit('No direct script access allowed');

use models\ModelFactory;

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
	 * Database library selection
	 *
	 * Just can use <code>doctrine</code> or <code>database</code>.
	 *
	 * @var			string
	 */
	const DATABASE_LIBRARY_DOCTRINE = 'doctrine';

	/**
	 * Database library selection
	 *
	 * Just can use <code>doctrine</code> or <code>database</code>.
	 *
	 * @var			string
	 */
	const DATABASE_LIBRARY_ACTIVITY_RECORD = 'database';

	/**
	 * Database library selection
	 *
	 * Just can use <code>doctrine</code> or <code>database</code>.
	 *
	 * @var			string
	 */
	const DATABASE_LIBRARY_NONE = 'none';

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
	public function __construct($layout, $database = self::DATABASE_LIBRARY_DOCTRINE)
	{
		parent::__construct();

		// Load library
		$this->load->library('Head');

		// Set default value
		$this->_blocks = new stdClass();
		$this->_data = array();
		$this->_layout = $layout;

		// Load database library
		switch ($database)
		{
			default :
			case self::DATABASE_LIBRARY_DOCTRINE :
				$this->load->library('doctrine');
				if ((ENVIRONMENT == 'development') && self::AUTO_UPDATE)
				{
					$this->updateSchema();
				}
				break;

			case self::DATABASE_LIBRARY_ACTIVITY_RECORD :
				break;
			case self::DATABASE_LIBRARY_NONE :
		}
	}

	/**
	 * Update database
	 */
	private function updateSchema()
	{
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
	 * Get model.
	 *
	 * @param		string	$model		Model's namespace and model's name.
	 * @param		string	$namespace	Namespace prefix.
	 *
	 * @return		models\Model
	 */
	public function getModel($model, $namespace = 'models')
	{
		return ModelFactory::getInstance($namespace . '\\' . $model);
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

	/**
	 * Get include content
	 *
	 * @param		string		$filename
	 * @param		array		$data
	 *
	 * @return		string		File contents.
	 */
	public function getInclude($filename, $data = array())
	{
		$result = null;
		foreach ($data as $key => $value)
		{
			if (!preg_match('/^\d/', $key))
			{
				$$key = $value;
			}
		}
		if (is_file($filename))
		{
			ob_start();
			include $filename;
			return ob_get_clean();
		}
		return $result;
	}

}
