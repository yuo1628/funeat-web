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
		$this->load->library('form_validation');

		// Load models
		$this->feature = new models\Feature();
		$this->restaurant = new models\Restaurant();
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
	 * Add action
	 */
	public function add()
	{
		$this->load->helper('form');

		$this->setData('features', $this->feature->getItems());
		$this->setData('restaurant', $this->restaurant->getInstance());
		$this->view('restaurant/edit');
	}

	/**
	 * Edit action
	 */
	public function edit($identity)
	{
		$this->load->helper('form');

		$this->setData('features', $this->feature->getItems());
		$this->setData('restaurant', $this->_loadRestaurant($identity));
		$this->view('restaurant/edit');
	}

	/**
	 * Save action
	 *
	 * @param		identity Can use ID, UUID or username.
	 *
	 * @param 		name
	 * @param		address
	 * @param		tels[]
	 * @param		emails[]
	 * @param		hours[]
	 * @param		website
	 * @param		logo (file)
	 * @param		images[] (files)
	 * @param		features[] (another table data)
	 */
	public function save($identity = null)
	{
		// preload data
		$restaurant = null;

		if ($identity === null)
		{
			// Set rules
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('address', 'Address', 'required');

			if ($this->form_validation->run() !== false)
			{
				$restaurant = $this->restaurant->getInstance();
			}
		}
		else
		{
			$identity = trim($identity);

			$restaurant = $this->_loadRestaurant($identity);
		}

		if ($restaurant === null)
		{
			if ($identity === null)
			{
				$this->load->helper('form');

				$this->setData('features', $this->feature->getItems());
				$this->view('restaurant/add');
			}
			else
			{
				$this->load->helper('form');

				$this->setData('features', $this->feature->getItems());
				$this->view('restaurant/edit');
			}
		}
		else
		{
			// Load data
			$name = trim($this->input->post('name'));
			$address = trim($this->input->post('address'));
			$tels = trim($this->input->post('tels'));
			$emails = trim($this->input->post('emails'));
			$hours = trim($this->input->post('hours'));
			$website = trim($this->input->post('website'));
			$logo = trim($this->input->post('logo'));
			$images = trim($this->input->post('images'));
			$features = trim($this->input->post('features'));

			$restaurant->name = empty($name) ? $restaurant->name : $name;
			$restaurant->address = empty($address) ? $restaurant->address : $address;

			// TODO:
			//$restaurant->tels = $tels;

			// TODO:
			//$restaurant->hours = $hours;

			$restaurant->website = empty($website) ? $restaurant->website : $website;

			// TODO:
			//$restaurant->images = $this->input->post('images');

			if ($features)
			{
				$featuresData;
				foreach ($features->input->post('features') as $v)
				{
					$featuresData[] = $this->feature->getItem((int)$v);
				}
				$restaurant->setFeatures($featuresData);
			}

			$this->restaurant->save($restaurant);

			// TODO: after save data?
		}
	}

	/**
	 * Processing features mapping
	 *
	 * @param	action
	 */
	public function feature($action = 'list')
	{
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		// Output default value
		$output = null;

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

				break;

			case self::FEATURE_ACTION_ADD :
				$this->load->library('form_validation');

				// Output default value
				$output = false;

				// TODO: Do auth and set creator

				// Set rules
				$this->form_validation->set_rules('title', 'Title', 'required');

				if ($this->form_validation->run() == true)
				{
					$title = trim($this->input->post('title'));
					$duplicate = $this->feature->getItem($title, 'title');

					if (empty($duplicate))
					{
						$parent = (int)$this->input->post('parent');

						$data = $this->feature->getInstance();
						$data->setTitle(trim($this->input->post('title')));

						if ($parent !== 0)
						{
							$parentItem = $this->feature->getItem($parent);
							$data->setParent($parentItem);
						}

						$this->feature->save($data);

						$output = $data->toArray();
						// unset($output['parent']['__isInitialized__']);
					}
				}
				break;

			case self::FEATURE_ACTION_UPDATE :
				$this->load->library('form_validation');

				// Output default value
				$output = false;

				// TODO: Do auth

				// Set rules
				$this->form_validation->set_rules('id', 'ID', 'required');
				$this->form_validation->set_rules('title', 'Title', 'required');

				if ($this->form_validation->run() == true)
				{
					$id = (int)$this->input->post('id');
					$item = $this->feature->getItem($id);

					if (!empty($item))
					{
						$parent = (int)$this->input->post('parent');

						$item->setTitle(trim($this->input->post('title')));

						if ($parent !== 0)
						{
							$parentItem = $this->feature->getItem($parent);
							$item->setParent($parentItem);
						}

						$this->feature->save($item);

						$output = $item->toArray(true);
						// unset($output['parent']['__isInitialized__']);
					}
				}
				break;

			case self::FEATURE_ACTION_DELETE :
				$this->load->library('form_validation');

				// Output default value
				$output = false;

				// TODO: Do auth

				// Set rules
				$this->form_validation->set_rules('id', 'ID', 'required');

				if ($this->form_validation->run() == true)
				{
					$id = (int)$this->input->post('id');
					$item = $this->feature->getItem($id);

					$this->feature->remove($item);

					$output = $item ? true : false;
				}
				break;
		}
		echo json_encode($output);
	}

	/**
	 * Load restaurant from identity
	 *
	 * @param		identity identity Can use ID, UUID or username.
	 */
	private function _loadRestaurant($identity)
	{
		$this->load->library('uuid');
		$restaurant = null;

		if ($this->uuid->is_valid($identity))
		{
			$items = $this->restaurant->getItem($identity, 'uuid');
			$restaurant = $items[0];
		}
		elseif (preg_match('/^\d+$/', $identity))
		{
			// match [0-9]
			$items = $this->restaurant->getItem($identity);
			$restaurant = $items;
		}
		elseif (preg_match('/^\w+$/', $identity))
		{
			// match [0-9a-zA-Z_]
			$items = $this->restaurant->getItem($identity, 'username');

			if ($items)
			{
				$restaurant = $items[0];
			}
		}

		return $restaurant;
	}

}
