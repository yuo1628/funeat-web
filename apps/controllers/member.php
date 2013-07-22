<?php defined('BASEPATH') or die('No direct script access allowed');

use models\Member as MemberModel;

/**
 * Member function
 */
class Member extends MY_Controller
{
	/**
	 * Register validation config
	 *
	 * @var array
	 */
	protected $register_validation = array(
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email'
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'trim|required|matches[confirmPassword]|md5'
		),
		array(
			'field' => 'confirmPassword',
			'label' => 'Confirm Password',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'privacy',
			'label' => 'Privacy',
			'rules' => 'required'
		)
	);

	/**
	 * Member model
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

		$this->member = new MemberModel();
	}

	/**
	 * Index page
	 */
	public function index()
	{
	}

	/**
	 * Register page
	 */
	public function register()
	{
		// Redirect page when user is login
		$redirect_page = '/member';

		// If isLogin ,then redirect
		if ($this->member->isLogin($this->session))
		{
			redirect($redirect_page, 'location', 301);
		}
		else
		{
			// load from validation library
			$this->load->library('form_validation');

			$this->form_validation->set_rules($this->register_validation);

			$email = $this->input->post('email');
			$duplicate = $this->member->getItem($email, 'email');

			if ($this->form_validation->run() == FALSE || $duplicate)
			{
				$this->load->helper('form');
				$this->view("member/register");
			}
			else
			{
				$password = $this->input->post('password');

				$member = $this->member->getInstance();

				$member->email = $email;
				$member->password = $password;

				$this->member->save($member);

				// TODO: after save data?
			}
		}
	}

}
