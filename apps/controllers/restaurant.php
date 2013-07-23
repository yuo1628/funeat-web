<?php defined('BASEPATH') or die('No direct script access allowed');

/**
 * Restaurant
 */
class Restaurant extends MY_Controller
{
	/**
	 * Feature action list constants
	 */
	const FEATURE_ACTION_LIST = 'list';

	/**
	 * Feature action list parameter for show restaurant
	 */
	const FEATURE_ACTION_LIST_RESTAURANT = 'restaurant';

	/**
	 * Feature action add constants
	 */
	const FEATURE_ACTION_ADD = 'add';

	/**
	 * Feature action update constants
	 */
	const FEATURE_ACTION_UPDATE = 'update';

	/**
	 * Feature action delete constants
	 */
	const FEATURE_ACTION_DELETE = 'delete';

	/**
	 * @var models\Restaurant
	 */
	protected $restaurant;

	/**
	 * @var models\Feature
	 */
	protected $feature;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('default');

		// Load library
		$this->load->library('doctrine');
	}

	/**
	 * Index page
	 */
	public function index($type = 'html')
	{
		switch ($type)
		{
			default :
			case self::OUTPUT_TYPE_HTML :
				$this->view('restaurant/list');
				break;
			case self::OUTPUT_TYPE_JSON :
				// TODO: output JSON
				break;
			case self::OUTPUT_TYPE_RSS :
				// TODO: output RSS
				break;
		}
	}

	/**
	 * Processing features mapping
	 *
	 * @param	action
	 */
	public function feature($action = 'list')
	{
		$this->feature = new models\Feature();

		switch ($action)
		{
			default :
			case self::FEATURE_ACTION_LIST :
				$list = $this->feature->getItems();
				$output = array();
				foreach ($list as $v)
				{
					$showRestaurant = $this->input->get(self::FEATURE_ACTION_LIST_RESTAURANT);

					if ($showRestaurant === false)
					{
						$output[] = $v->toArray(false);
					}
					else
					{
						$output[] = $v->toArray(true);
					}
				}
				header('Cache-Control: no-cache');
				header('Content-type: application/json');

				echo json_encode($output);
				break;
			case self::FEATURE_ACTION_ADD :
				// TODO:
				$data = $this->feature->getInstance();
				//$this->feature->save($data);
				break;
			case self::FEATURE_ACTION_UPDATE :
				// TODO:
				break;
			case self::FEATURE_ACTION_DELETE :
				// TODO:
				break;
		}
	}

}
