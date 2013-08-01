<?php defined('BASEPATH') or exit('No direct script access allowed');

use models\Member as MemberModel;
use models\member\Comment as CommentModel;
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
	public function __construct()
	{
		parent::__construct('default');

		// Load library
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('form_validation');
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
		if (MemberModel::isLogin($this->session))
		{
			redirect($redirect_page, 'location', 301);
		}
		else
		{
			// load from validation library
			$this->load->library('form_validation');

			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required|matches[confirmPassword]');
			$this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required');
			$this->form_validation->set_rules('privacy', 'Privacy', 'required');

			if ($this->form_validation->run() == false)
			{
				$this->load->helper('form');
				$this->view("member/register");
			}
			else
			{
				/**
				 * @var models\Member
				 */
				$memberModel = $this->getModel('Member');

				$email = $this->input->post('email');
				$duplicate = $memberModel->getItem($email, 'email');

				if ($duplicate)
				{
					// The Email has been used.
					$this->load->helper('form');
					$this->view("member/register");
				}
				else
				{
					$password = $this->input->post('password');

					$member = $memberModel->getInstance();

					$member->email = $email;
					$member->password = $password;

					$memberModel->save($member);

					// TODO: after save data?
				}
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
		 * @var models\Member
		 */
		$memberModel = $this->getModel('Member');

		/**
		 * @var models\entity\member\Members
		 */
		$memberSelect = $memberModel->getItemByIdentity($identity);

		$success = false;

		if (MemberModel::isLogin($this->session) && !empty($memberSelect))
		{
			/**
			 * @var models\entity\member\Members
			 */
			$member = $memberModel->getLoginMember($this->session);
			$like = $memberSelect->getLike();

			if ($like->contains($member))
			{
				$like->removeElement($member);
			}
			else
			{
				$like->add($member);
			}

			$memberModel->save($memberSelect);

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
	public function comment($identity)
	{
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		/**
		 * @var models\Member
		 */
		$memberModel = $this->getModel('Member');

		/**
		 * @var models\entity\member\Members
		 */
		$member = $memberModel->getItemByIdentity($identity);

		$success = false;

		if (MemberModel::isLogin($this->session) && !empty($member))
		{
			// Set rules
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');

			if ($this->form_validation->run() == true)
			{
				/**
				 * @var models\member\Comment
				 */
				$commentModel = $this->getModel('member\\Comment');

				/**
				 * @var models\entity\member\Comments
				 */
				$comment = $commentModel->getInstance();

				/**
				 * @var models\entity\member\Members
				 */
				$creator = $memberModel->getLoginMember($this->session);

				// TODO How to decide type?
				$type = Comments::TYPE_MEMBER;

				$comment->setComment($this->input->post('comment'));
				$comment->setCreator($creator, $type);
				$comment->setMember($member);

				$commentModel->save($comment);

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
		 * @var models\member\Comment
		 */
		$commentModel = $this->getModel('member\\Comment');

		/**
		 * @var models\entity\member\Comments
		 */
		$reply = $commentModel->getItemByIdentity($identity);

		$success = false;

		if (MemberModel::isLogin($this->session) && !empty($reply))
		{
			// Set rules
			$this->form_validation->set_rules('comment', 'Comment', 'required');

			if ($this->form_validation->run() == true)
			{

				/**
				 * @var models\Member
				 */
				$memberModel = $this->getModel('Member');

				/**
				 * @var models\entity\member\Comments
				 */
				$comment = $commentModel->getInstance();

				/**
				 * @var models\entity\member\Members
				 */
				$creator = $memberModel->getLoginMember($this->session);

				// TODO How to decide type?
				$type = Comments::TYPE_MEMBER;

				$comment->setComment($this->input->post('comment'));
				$comment->setCreator($creator, $type);
				$comment->setReply($reply);

				$commentModel->save($comment);

				$success = true;
			}
		}

		echo json_encode($success);
	}

}
