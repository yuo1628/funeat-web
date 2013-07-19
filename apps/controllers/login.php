<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Login extends MY_Controller
{
	/**
	 * Validation config
	 *
	 * @var array
	 */
	protected $validation_config = array(
		array(
			'field' => 'identity',
			'label' => 'Identity',
			'rules' => 'required'
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required'
		)
	);

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('default');

		// Load ORM library
		$this->load->library('doctrine');

	}

	/**
	 * Main action
	 */
	public function index()
	{
		// load from validation library
		$this->load->library('form_validation');

		$this->form_validation->set_rules($this->validation_config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->helper('form');
			$this->view("user/login");
		}
		else
		{
			$identity = $this->input->post('identity');
			$password = $this->input->post('password');

			$members = new models\Member();

			$member = $members->verify($identity, $password);

			if (empty($member))
			{
				// TODO when login failed
				echo 'Login Failed!';
			}
			else
			{
				// TODO when login OK
				echo 'Login OK!';
			}
		}
	}

}
