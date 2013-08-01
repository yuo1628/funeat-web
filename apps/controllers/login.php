<?php defined('BASEPATH') or exit('No direct script access allowed');

use models\Member as MemberModel;

/**
 * Login function
 *
 * @author		Miles <jangconan@gmail.com>
 */
class Login extends MY_Controller
{
	/**
	 * Redirect page when user is login
	 *
	 * @var string
	 */
	protected $redirect_page = '/';

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
	 * Main action
	 */
	public function index()
	{

		// If isLogin ,then redirect
		if (MemberModel::isLogin($this->session))
		{
			redirect($this->redirect_page, 'location', 301);
		}
		else
		{
			// load from validation library
			$this->load->library('form_validation');

			$this->form_validation->set_rules('identity', 'Identity', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->helper('form');
				$this->view("member/login");
			}
			else
			{
				$identity = $this->input->post('identity');
				$password = $this->input->post('password');

				/**
				 * @var models\Member
				 */
				$memberModel = $this->getModel('Member');

				$member = $memberModel->verify($identity, $password);

				if (empty($member))
				{
					// TODO when login failed

					echo 'Login Failed!';
				}
				else
				{
					// TODO when login OK

					MemberModel::login($this->session, $member);
					echo 'Login OK!';
				}
			}
		}
	}

}
