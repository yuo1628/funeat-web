<?php defined('BASEPATH') or exit('No direct script access allowed');

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
	 * Redirect page when user is login
	 *
	 * @var string
	 */
	protected $redirect_page = '/';

	/**
	 * Redirect page when user is login
	 *
	 * @var models\entity\member\Members
	 */
	protected $member;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('default');

		// Load library
		$this->load->library('doctrine');
		$this->load->helper('url');
		$this->load->library('session');

	}

	/**
	 * Main action
	 */
	public function index()
	{
		$this->member = new models\Member();

		// If isLogin ,then redirect
		if ($this->member->isLogin($this->session))
		{
			redirect($this->redirect_page, 'location', 301);
		}
		else
		{
			// load from validation library
			$this->load->library('form_validation');

			$this->form_validation->set_rules($this->validation_config);

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->helper('form');
				$this->view("member/login");
			}
			else
			{
				$identity = $this->input->post('identity');
				$password = $this->input->post('password');

				$member = $this->member->verify($identity, $password);

				if (empty($member))
				{
					// TODO when login failed

					echo 'Login Failed!';
				}
				else
				{
					// TODO when login OK

					$this->member->login($this->session, $member);
					echo 'Login OK!';
				}
			}
		}
	}

}
