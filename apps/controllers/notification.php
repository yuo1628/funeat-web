<?php defined('BASEPATH') or exit('No direct script access allowed');

use models\FuneatFactory;
use models\ModelFactory;
use models\Member as MemberModel;

/**
 * Notification controller
 *
 * @author		Miles <jangconan@gmail.com>
 */
class Notification extends MY_Controller
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('default');

		// Load library
		$this->load->helper('url');
		$this->load->library('session');
	}

	/**
	 * Default
	 */
	public function index()
	{
		// If isLogin ,then redirect
		if (FuneatFactory::isLogin())
		{
			$member = FuneatFactory::getMember();
		}
		else
		{
			redirect('login', 'location', 301);
		}
	}

	/**
	 * Type manager
	 */
	public function type()
	{
		$typeModel = $this->getModel('notification\\Type');

		$this->setData('types', $typeModel->getItems());
		$this->view('notification/type');
	}

	public function typeSave($identity = null)
	{
		/**
		 * @var		models\entity\notification\Type
		 */
		$type = null;

		$typeModel = $this->getModel('notification\\Type');

		if ($type === null)
		{
			$this->load->library('form_validation');

			// Set form validation rules
			$this->form_validation->set_rules('action', 'Action', 'required');
			$this->form_validation->set_rules('template', 'Template', 'required');

			if ($this->form_validation->run() !== false)
			{
				$type = $typeModel->getInstance();
			}
		}
		else
		{
			// Load data when identity is not null.
			$identity = trim($identity);

			$type = $typeModel->getItem($identity);
		}

		// It not vaild when restaurant is null
		if (FuneatFactory::isLogin() && !empty($type))
		{
			// Assign normal data
			$type->setAction($this->input->post('action'));
			$type->setLanguage($this->input->post('language'));
			$type->setTemplate($this->input->post('template'));

			// Saving data
			$typeModel->save($type);

			// After save data
			$this->load->helper('url');

			redirect('notification/type', 'location', 301);
		}
		else
		{
		}
	}

}
