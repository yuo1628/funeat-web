<?php defined('BASEPATH') or exit('No direct script access allowed');

use models\FuneatFactory;
use models\Member as MemberModel;

/**
 * Login function
 *
 * @author		Miles <jangconan@gmail.com>
 */
class Login extends MY_Controller {
	/**
	 * Redirect page when user is login
	 *
	 * @var string
	 */
	protected $redirect_page = '/';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct('default');

		// Load library
		$this -> load -> helper('url');
		$this -> load -> library('session');
	}

	/**
	 * Main action
	 */
	public function index() {

		// If isLogin ,then redirect
		if (FuneatFactory::isLogin()) {
			redirect('member/profile', 'location', 301);
		} else {
			// load from validation library
			$this -> load -> library('form_validation');

			$this -> form_validation -> set_rules('identity', 'Identity', 'trim|required');
			$this -> form_validation -> set_rules('password', 'Password', 'trim|required');

			if ($this -> form_validation -> run() == FALSE) {
				$this -> load -> helper('form');
				
				$this->head->addScript('js/jquery.validate.js');
				$this->head->addScript('js/member_login.js');
				$this->head->addStyleSheet('css/member_login.css');				
				$this -> view("member/login");
			} else {
				$identity = $this -> input -> post('identity');
				$password = $this -> input -> post('password');

				/**
				 * @var models\Member
				 */
				$memberModel = $this -> getModel('Member');

				$member = $memberModel -> verify($identity, $password);

				if (empty($member)) {
					// TODO when login failed

					echo 'Login Failed!';
				} else {
					// TODO when login OK

					MemberModel::login($this -> session, $member);
					echo 'Login OK!';
				}
			}
		}
	}

}
