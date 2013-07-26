<?php defined('BASEPATH') or die('No direct script access allowed');

use models\Member as MemberModel;
use models\entity\member\Comments as Comments;

/**
 * Member function
 *
 * @author		Miles <jangconan@gmail.com>
 */
class Member extends MY_Controller
{
	/**
	 * Use id to select member
	 */
	const IDENTITY_SELECT_ID = false;

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
			'rules' => 'trim|required|matches[confirmPassword]'
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
	 * @var models\Comment
	 */
	protected $comment;

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
		$this->load->library('form_validation');

		$this->member = new MemberModel();
		$this->comment = new models\member\Comment();
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

			if ($this->form_validation->run() == false || $duplicate)
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

	/**
	 * Like the member action
	 *
	 * @param		identity Can use ID, UUID or username.
	 */
	public function like($identity)
	{
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		/**
		 * @var models\entity\restaurant\Comments
		 */
		$memberSelect = $this->_loadMember($identity);

		$success = false;

		if ($this->member->isLogin($this->session) && !empty($memberSelect))
		{
			/**
			 * @var models\entity\member\Members
			 */
			$member = $this->member->getLoginMember($this->session);
			$like = $memberSelect->getLike();

			if ($like->contains($member))
			{
				$like->removeElement($member);
			}
			else
			{
				$like->add($member);
			}

			$this->member->save($memberSelect);

			$success = true;
		}
		echo json_encode($success);
	}

	/**
	 * Comment the member action
	 *
	 * @param		identity Can use ID, UUID or username.
	 */
	public function comment($identity)
	{
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		/**
		 * @var models\entity\member\Members
		 */
		$memberSelect = $this->_loadMember($identity);

		$success = false;

		if ($this->member->isLogin($this->session) && !empty($memberSelect))
		{
			// Set rules
			$this->form_validation->set_rules('comment', 'Comment', 'required');

			if ($this->form_validation->run() == true)
			{
				/**
				 * @var models\entity\member\Comments
				 */
				$commentInstance = $this->comment->getInstance();

				/**
				 * @var models\entity\member\Members
				 */
				$member = $this->member->getLoginMember($this->session);

				// TODO How to decide type?
				$type = Comments::TYPE_MEMBER;

				$comment = trim($this->input->post('comment'));

				$commentInstance->setComment($comment);
				$commentInstance->setCreator($member, $type);
				$commentInstance->setMember($memberSelect);

				$this->comment->save($commentInstance);

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
	public function reply($identity)
	{
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		/**
		 * @var models\entity\member\Members
		 */
		$reply = $this->_loadComment($identity);

		$success = false;

		if ($this->member->isLogin($this->session) && !empty($reply))
		{
			// Set rules
			$this->form_validation->set_rules('comment', 'Comment', 'required');

			if ($this->form_validation->run() == true)
			{
				/**
				 * @var models\entity\member\Comments
				 */
				$commentInstance = $this->comment->getInstance();

				/**
				 * @var models\entity\member\Members
				 */
				$member = $this->member->getLoginMember($this->session);

				// TODO How to decide type?
				$type = Comments::TYPE_MEMBER;

				$comment = trim($this->input->post('comment'));

				$commentInstance->setComment($comment);
				$commentInstance->setCreator($member, $type);
				$commentInstance->setReply($reply);

				$this->comment->save($commentInstance);

				$success = true;
			}
		}
		echo json_encode($success);
	}

	/**
	 * Load member from identity
	 *
	 * @param		identity Identity Can use ID, UUID, username.
	 *
	 * @return		models\entity\member\Members
	 */
	private function _loadMember($identity)
	{
		$identity = trim($identity);

		$this->load->library('uuid');
		$member = null;

		if ($this->uuid->is_valid($identity))
		{
			$member = $this->member->getItem($identity, 'uuid');
		}
		elseif ((int)$identity > 0 && self::IDENTITY_SELECT_ID)
		{
			// integer
			$member = $this->member->getItem((int)$identity);
		}
		elseif (preg_match('/^\w+$/', $identity))
		{
			// match [0-9a-zA-Z_]+
			$member = $this->member->getItem($identity, 'username');
		}

		return $member;
	}

	/**
	 * Load comment from identity
	 *
	 * @param		identity Identity Can use ID, UUID.
	 *
	 * @return		models\entity\restaurant\Comments
	 */
	private function _loadComment($identity)
	{
		$identity = trim($identity);

		$this->load->library('uuid');
		$comment = null;

		if ($this->uuid->is_valid($identity))
		{
			$comment = $this->comment->getItem($identity, 'uuid');
		}
		elseif ((int)$identity > 0 && self::IDENTITY_SELECT_ID)
		{
			// integer
			$comment = $this->comment->getItem((int)$identity);
		}

		return $comment;
	}
}
