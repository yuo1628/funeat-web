<?php defined('BASEPATH') or die('No direct script access allowed');

/**
 * Restaurant
 */
class Restaurant extends MY_Controller
{
	/**
	 * @var models\entity\member\Restaurants
	 */
	protected $restaurant;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('default');

		// Load library
		$this->load->library('doctrine');
		$this->load->library('form_validation');
	}

	/**
	 * Index page
	 */
	public function index($type = 'html')
	{

		$this->restaurant = new models\Restaurant();
		switch ($type)
		{
			default :
			case MY_Controller::OUTPUT_TYPE_HTML :
				$this->view('restaurant/list');
				break;
			case MY_Controller::OUTPUT_TYPE_JSON :
				// TODO: output JSON
				break;
			case MY_Controller::OUTPUT_TYPE_RSS :
				// TODO: output RSS
				break;
		}
	}

}
