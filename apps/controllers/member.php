<?php defined('BASEPATH') or exit('No direct script access allowed');

use models\FuneatFactory;
use models\Member as MemberModel;
use models\member\Comment as CommentModel;
use models\entity\member\Comments as Comments;

/**
 * Member function
 *
 * @author		Miles <jangconan@gmail.com>
 */
class Member extends MY_Controller {
	/**
	 * Use id to select member
	 */
	const IDENTITY_SELECT_ID = false;

	/**
	 * Member model
	 *
	 * @var models\Members
	 */
	protected $member;

	/**
	 * @var models\member\Comment
	 */
	protected $comment;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct('default');

		// Load library
		$this -> load -> helper('url');
		$this -> load -> library('session');
		$this -> load -> library('form_validation');
	}

	/**
	 * Index page
	 */
	public function index() {
	}

	/**
	 * Register page
	 */
	public function register() {
		// Redirect page when user is login
		$redirect_page = '/member';

		// If isLogin ,then redirect

		if (FuneatFactory::isLogin()) {
			redirect($redirect_page, 'location', 301);
		} else {
			// load from validation library
			$this -> load -> library('form_validation');

			$this -> form_validation -> set_rules('email', 'Email', 'required|valid_email');
			$this -> form_validation -> set_rules('password', 'Password', 'required|matches[confirmPassword]');
			$this -> form_validation -> set_rules('confirmPassword', 'Confirm Password', 'required');
			$this -> form_validation -> set_rules('name', 'Name', 'required');
			$this -> form_validation -> set_rules('privacy', 'Privacy', 'required');

			if ($this -> form_validation -> run() == false) {
				$this -> load -> helper('form');
				$this -> head -> addScript('js/jquery.validate.js');
				$this -> head -> addScript('js/member_register.js');
				$this -> head -> addStyleSheet('css/member_register.css');
				$this -> view("member/register");
			} else {
				/**
				 * @var models\Member
				 */
				$memberModel = $this -> getModel('Member');

				$email = $this -> input -> post('email');
				$duplicate = $memberModel -> getItem($email, 'email');

				if ($duplicate) {
					// The Email has been used.
					$this -> load -> helper('form');
					$this -> view("member/register");
				} else {
					$password = $this -> input -> post('password');
					$name = $this -> input -> post('name');
					$member = $memberModel -> getInstance();
					$member -> email = $email;
					$member -> password = $password;
					$member -> name = $name;
					$memberModel -> save($member);

					// TODO: after save data?

					$this -> load -> helper('url');
					redirect('login', 'location', 301);
				}
			}
		}
	}

	/**
	 * Like the member action
	 *
	 * @param		identity Can use ID, UUID or username.
	 */
	public function like($identity) {
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		/**
		 * @var models\Member
		 */
		$memberModel = $this -> getModel('Member');

		/**
		 * @var models\entity\member\Members
		 */
		$memberSelect = $memberModel -> getItemByIdentity($identity);

		$success = false;

		if (FuneatFactory::isLogin() && !empty($memberSelect)) {
			/**
			 * @var models\entity\member\Members
			 */
			$member = $memberModel -> getLoginMember($this -> session);
			$like = $memberSelect -> getLike();

			if ($like -> contains($member)) {
				$like -> removeElement($member);
			} else {
				$like -> add($member);
			}

			$memberModel -> save($memberSelect);

			$success = true;
		}

		echo json_encode($success);
	}

	/**
	 * Comment the member action
	 *
	 * @param		identity Can use ID, UUID or username.
	 *
	 * @param		comment
	 */
	public function comment($identity) {
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		/**
		 * @var models\Member
		 */
		$memberModel = $this -> getModel('Member');

		/**
		 * @var models\entity\member\Members
		 */
		$member = $memberModel -> getItemByIdentity($identity);

		$success = false;

		if (FuneatFactory::isLogin() && !empty($member)) {
			// Set rules
			$this -> form_validation -> set_rules('comment', 'Comment', 'trim|required');

			if ($this -> form_validation -> run() == true) {
				/**
				 * @var models\member\Comment
				 */
				$commentModel = $this -> getModel('member\\Comment');

				/**
				 * @var models\entity\member\Comments
				 */
				$comment = $commentModel -> getInstance();

				/**
				 * @var models\entity\member\Members
				 */
				$creator = $memberModel -> getLoginMember($this -> session);

				// TODO How to decide type?
				$type = Comments::TYPE_MEMBER;

				$comment -> setComment($this -> input -> post('comment'));
				$comment -> setMember($member);

				$commentModel -> save($comment);

				$success = true;
			}
		}

		echo json_encode($success);
	}

	/**
	 * Reply the comment action
	 *
	 * @param		identity Can use ID, UUID.
	 *
	 * @param		comment
	 */
	public function reply($identity) {
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		/**
		 * @var models\member\Comment
		 */
		$commentModel = $this -> getModel('member\\Comment');

		/**
		 * @var models\entity\member\Comments
		 */
		$reply = $commentModel -> getItemByIdentity($identity);

		$success = false;

		if (FuneatFactory::isLogin() && !empty($reply)) {
			// Set rules
			$this -> form_validation -> set_rules('comment', 'Comment', 'required');

			if ($this -> form_validation -> run() == true) {

				/**
				 * @var models\Member
				 */
				$memberModel = $this -> getModel('Member');

				/**
				 * @var models\entity\member\Comments
				 */
				$comment = $commentModel -> getInstance();

				/**
				 * @var models\entity\member\Members
				 */
				$creator = $memberModel -> getLoginMember($this -> session);

				// TODO How to decide type?
				$type = Comments::TYPE_MEMBER;

				$comment -> setComment($this -> input -> post('comment'));
				$comment -> setReply($reply);

				$commentModel -> save($comment);

				$success = true;
			}
		}

		echo json_encode($success);
	}

	/**
	 * Restaurant profile page
	 *
	 * @param		identity Can use ID, UUID or username.
	 */
	public function profile($format = self::OUTPUT_FORMAT_HTML) {
		if (FuneatFactory::isLogin()) {

			switch ($format) {
				default :
				case self::OUTPUT_FORMAT_HTML :
					// Set output data

					$this -> setData('member', FuneatFactory::getMember());

					// Add stylesheets & scripts
					$this -> head -> addStyleSheet('css/gallery.css');
					$this -> head -> addStyleSheet('css/restaurant_edit.css');
					$this -> head -> addStyleSheet('css/member_profile.css');
					$this -> head -> addScript('js/restaurant_edit.js');
					/* 	 $this->head->addScript('js/gallery.js');
					 $this->head->addScript('js/restaurant_like.js');
					 $this->head->addScript('js/restaurant_reply.js');
					 */

					$this -> view('member/profile');
					break;

				case self::OUTPUT_FORMAT_JSON :
					// Set html header
					header('Cache-Control: no-cache');
					header('Content-type: application/json');

					break;

				case self::OUTPUT_FORMAT_RSS :
					// TODO: output RSS
					break;
			}

		} else {
			redirect('login', 'location', 301);
		}
	}

}
