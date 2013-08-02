<?php defined('BASEPATH') or exit('No direct script access allowed');

use models\Feature as FeatureModel;

/**
 * Restaurant
 *
 * @author		Miles <jangconan@gmail.com>
 */
class Feature extends MY_Controller
{
	/**
	 * @var models\Feature
	 */
	protected $featureModel;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('default');

		// Load library
		$this->load->library('form_validation');
		$this->load->library('session');

		// Load models
		$this->featureModel = $this->getModel('Feature');
	}

	/**
	 * Index page
	 *
	 * @return		HTML
	 */
	public function index()
	{
		// Add style sheet
		$this->setData('features', $this->featureModel->getItems());
		$this->head->addStyleSheet('css/feature_list.css');

		$this->view('feature/list');
	}

	/**
	 * Add action
	 */
	public function add()
	{
	}

	/**
	 * Edit action
	 */
	public function edit($identity)
	{
	}

	/**
	 * Save action
	 */
	public function save($identity = null)
	{
	}

	/**
	 * delete action
	 */
	public function delete($identity)
	{
	}


}
