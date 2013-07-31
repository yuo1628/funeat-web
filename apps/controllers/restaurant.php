<?php defined('BASEPATH') or die('No direct script access allowed');

use models\entity\restaurant\Comments as Comments;
use models\entity\image\Images as Images;

/**
 * Restaurant
 */
class Restaurant extends MY_Controller
{
	/**
	 * Use id to select restaurant
	 */
	const IDENTITY_SELECT_ID = false;

	/**
	 * Feature action list constants
	 */
	const FEATURE_ACTION_LIST = 'list';

	/**
	 * Feature action list parameter for show restaurant
	 */
	const FEATURE_ACTION_LIST_RESTAURANT = 'restaurant';

	/**
	 * Feature action add constants
	 */
	const FEATURE_ACTION_ADD = 'add';

	/**
	 * Feature action update constants
	 */
	const FEATURE_ACTION_UPDATE = 'update';

	/**
	 * Feature action delete constants
	 */
	const FEATURE_ACTION_DELETE = 'delete';

	/**
	 * @var models\Restaurant
	 */
	protected $restaurant;

	/**
	 * @var models\Feature
	 */
	protected $feature;

	/**
	 * @var models\Member
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
		$this->load->library('form_validation');
		$this->load->library('session');

		// Load models
		$this->feature = new models\Feature();
		$this->restaurant = new models\Restaurant();
		$this->member = new models\Member();
		$this->comment = new models\restaurant\Comment();
	}

	/**
	 * Index page
	 */
	public function index($format = 'html')
	{
		switch ($format)
		{
			default :
			case self::OUTPUT_FORMAT_HTML :
				// Add style sheet
				$this->head->addStyleSheet('css/gallery.css');
				$this->head->addStyleSheet('css/restaurant_list.css');

				$this->setData('restaurants', $this->restaurant->getItems());

				$this->view('restaurant/list');
				break;
			case self::OUTPUT_FORMAT_JSON :
				// TODO: output JSON
				break;
			case self::OUTPUT_FORMAT_RSS :
				// TODO: output RSS
				break;
		}
	}

	/**
	 * Restaurant profile page
	 *
	 * @param		identity Can use ID, UUID or username.
	 */
	public function profile($identity, $format = self::OUTPUT_FORMAT_HTML)
	{
		$restaurant = $this->_loadRestaurant($identity);

		$member = null;

		if ($this->member->isLogin($this->session) && !empty($restaurant))
		{
			$member = $this->member->getLoginMember($this->session);
		}

		switch ($format)
		{
			default :
			case self::OUTPUT_FORMAT_HTML :
				$this->setData('restaurant', $restaurant);
				$this->setData('member', $member);

				// Add style sheet
				$this->head->addStyleSheet('css/gallery.css');
				$this->head->addStyleSheet('css/restaurant.css');
				$this->head->addStyleSheet('http://fonts.googleapis.com/css?family=ABeeZee');
				$this->head->addScript('js/gallery.js');
				$this->head->addScript('js/restaurant_like.js');
				$this->head->addScript('js/restaurant_reply.js');

				$this->view('restaurant/profile');
				break;

			case self::OUTPUT_FORMAT_JSON :
				// Set html header
				header('Cache-Control: no-cache');
				header('Content-type: application/json');

				if ($restaurant === null)
				{
					echo json_encode(null);
				}
				else
				{
					echo json_encode($restaurant->toArray(true));
				}
				break;

			case self::OUTPUT_FORMAT_RSS :
				// TODO: output RSS
				break;
		}
	}

	/**
	 * Add action
	 */
	public function add()
	{
		if ($this->member->isLogin($this->session))
		{
			$this->load->helper('form');

			$this->setData('features', $this->feature->getItems());
			$this->setData('restaurant', $this->restaurant->getInstance());

			// Add style sheet
			$this->head->addStyleSheet('css/gallery.css');
			$this->head->addStyleSheet('css/restaurant_edit.css');

			$this->view('restaurant/edit');
		}
		else
		{
			$this->load->helper('url');

			redirect('/login', 'location', 301);
		}
	}

	/**
	 * Edit action
	 */
	public function edit($identity)
	{
		$this->load->helper('form');

		$this->setData('features', $this->feature->getItems());
		$this->setData('restaurant', $this->_loadRestaurant($identity));
		$this->view('restaurant/edit');
	}

	/**
	 * Save action
	 *
	 * @param		identity Can use ID, UUID or username.
	 *
	 * @param 		name
	 * @param		address
	 * @param		tels[]
	 * @param		emails[]
	 * @param		hours[]
	 * @param		website
	 * @param		logo (file)
	 * @param		images[] (files)
	 * @param		features[] (another table data)
	 */
	public function save($identity = null)
	{
		/**
		 * @var		models\entity\restaurant\Restaurants
		 */
		$restaurant = null;

		if ($identity === null)
		{
			// Initial restaurant data when identity is null.

			// Set form validation rules
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('latitude', 'Latitude', 'required');
			$this->form_validation->set_rules('longitude', 'Longitude', 'required');

			if ($this->form_validation->run() !== false)
			{
				$restaurant = $this->restaurant->getInstance();
			}
		}
		else
		{
			// Load restaurant data when identity is not null.
			$identity = trim($identity);

			$restaurant = $this->_loadRestaurant($identity);
		}

		// It not vaild when restaurant is null
		if ($this->member->isLogin($this->session) && !empty($restaurant))
		{
			// Do data saving

			/**
			 * Load creator
			 *
			 * @var models/entity/member/Members
			 */
			$creator = $this->member->getLoginMember($this->session);

			// Assign normal data
			$restaurant->setName($this->input->post('name'));
			$restaurant->setAddress($this->input->post('address'));
			$restaurant->setLatLng($this->input->post('latitude'), $this->input->post('longitude'));
			$restaurant->setAddress($this->input->post('address'));
			$restaurant->setTel($this->input->post('tel'));
			$restaurant->setFax($this->input->post('fax'));
			$restaurant->setWebsite($this->input->post('website'));
			$restaurant->setEmail($this->input->post('email'));
			$restaurant->setPriceHigh($this->input->post('priceHigh'));
			$restaurant->setPriceLow($this->input->post('priceLow'));

			// Assign Many-To-Many relation data
			$restaurant->setFeatures($this->input->post('features'), $this->feature);

			// Assign upload image data
			$this->load->library('upload');
			$this->load->helper('file');

			/**
			 * @var MY_Upload
			 */
			$upload = $this->upload;

			/**
			 * @var models\Image
			 */
			$image = new models\Image();

			// Image stack
			$images = array();

			$restaurant->setLogo($image->upload($upload, $creator, 'logo'));
			$restaurant->setGallery($image->upload($upload, $creator, 'gallery', true));
			$restaurant->setMenu($image->upload($upload, $creator, 'menu', true));

			// TODO: Assign special data
			//$restaurant->hours = $hours;

			// Saving data
			$this->restaurant->save($restaurant);

			// After save data
			$this->load->helper('url');

			redirect('/restaurant/' . $restaurant->getUuid(), 'location', 301);
		}
		else
		{
			if (!$this->member->isLogin($this->session))
			{
				$this->load->helper('url');

				redirect('/login', 'location', 301);
			}
			else if ($identity === null)
			{
				$this->load->helper('form');

				$this->setData('features', $this->feature->getItems());
				$this->view('restaurant/add');
			}
			else
			{
				$this->load->helper('form');

				$this->setData('features', $this->feature->getItems());
				$this->view('restaurant/edit');
			}
		}
	}

	/**
	 * Like action for restaurant
	 *
	 * @param		identity Can use ID, UUID or username.
	 */
	public function like($identity)
	{
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		/**
		 * @var models\entity\restaurant\Restaurants
		 */
		$restaurant = $this->_loadRestaurant($identity);

		$success = false;

		if ($this->member->isLogin($this->session) && !empty($restaurant))
		{
			$member = $this->member->getLoginMember($this->session);

			if (!$restaurant->like->contains($member))
			{
				if ($restaurant->dislike->contains($member))
				{
					$restaurant->dislike->removeElement($member);
				}
				$restaurant->like->add($member);
				$this->restaurant->save($restaurant);
				$success = true;
			}
		}
		echo json_encode($success);
	}

	/**
	 * Dislike action for restaurant
	 *
	 * @param		identity Can use ID, UUID or username.
	 */
	public function dislike($identity)
	{
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		/**
		 * @var models\entity\restaurant\Restaurants
		 */
		$restaurant = $this->_loadRestaurant($identity);

		$success = false;

		if ($this->member->isLogin($this->session) && !empty($restaurant))
		{
			$member = $this->member->getLoginMember($this->session);

			if (!$restaurant->dislike->contains($member))
			{
				if ($restaurant->like->contains($member))
				{
					$restaurant->like->removeElement($member);
				}
				$restaurant->dislike->add($member);
				$this->restaurant->save($restaurant);
				$success = true;
			}
		}
		echo json_encode($success);
	}

	/**
	 * Processing features mapping
	 *
	 * @param	action
	 */
	public function feature($action = 'list')
	{
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		// Output default value
		$output = null;

		switch ($action)
		{
			default :
			case self::FEATURE_ACTION_LIST :
				$list = $this->feature->getItems();
				$output = array();
				foreach ($list as $v)
				{
					$showRestaurant = $this->input->get(self::FEATURE_ACTION_LIST_RESTAURANT);

					if ($showRestaurant === false)
					{
						$output[] = $v->toArray(false);
					}
					else
					{
						$output[] = $v->toArray(true);
					}
				}

				break;

			case self::FEATURE_ACTION_ADD :
				$this->load->library('form_validation');

				// Output default value
				$output = false;

				// TODO: Do auth and set creator

				// Set rules
				$this->form_validation->set_rules('title', 'Title', 'required');

				if ($this->form_validation->run() == true)
				{
					$title = trim($this->input->post('title'));
					$duplicate = $this->feature->getItem($title, 'title');

					if (empty($duplicate))
					{
						$parent = (int)$this->input->post('parent');

						$data = $this->feature->getInstance();
						$data->setTitle(trim($this->input->post('title')));

						if ($parent !== 0)
						{
							$parentItem = $this->feature->getItem($parent);
							$data->setParent($parentItem);
						}

						$this->feature->save($data);

						$output = $data->toArray();
						// unset($output['parent']['__isInitialized__']);
					}
				}
				break;

			case self::FEATURE_ACTION_UPDATE :
				$this->load->library('form_validation');

				// Output default value
				$output = false;

				// TODO: Do auth

				// Set rules
				$this->form_validation->set_rules('id', 'ID', 'required');
				$this->form_validation->set_rules('title', 'Title', 'required');

				if ($this->form_validation->run() == true)
				{
					$id = (int)$this->input->post('id');
					$item = $this->feature->getItem($id);

					if (!empty($item))
					{
						$parent = (int)$this->input->post('parent');

						$item->setTitle(trim($this->input->post('title')));

						if ($parent !== 0)
						{
							$parentItem = $this->feature->getItem($parent);
							$item->setParent($parentItem);
						}

						$this->feature->save($item);

						$output = $item->toArray(true);
						// unset($output['parent']['__isInitialized__']);
					}
				}
				break;

			case self::FEATURE_ACTION_DELETE :
				$this->load->library('form_validation');

				// Output default value
				$output = false;

				// TODO: Do auth

				// Set rules
				$this->form_validation->set_rules('id', 'ID', 'required');

				if ($this->form_validation->run() == true)
				{
					$id = (int)$this->input->post('id');
					$item = $this->feature->getItem($id);

					$this->feature->remove($item);

					$output = $item ? true : false;
				}
				break;
		}
		echo json_encode($output);
	}

	/**
	 * Comment the restaurant
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
		 * @var models\entity\restaurant\Restaurants
		 */
		$restaurant = $this->_loadRestaurant($identity);

		$success = false;

		if ($this->member->isLogin($this->session) && !empty($restaurant))
		{
			// Set rules
			$this->form_validation->set_rules('comment', 'Comment', 'required');

			if ($this->form_validation->run() == true)
			{
				/**
				 * @var models\entity\restaurant\Comments
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
				$commentInstance->setRestaurant($restaurant);

				$this->comment->save($commentInstance);

				$success = true;
			}
		}
		echo json_encode($success);
	}

	/**
	 * Reply the comment
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
		 * @var models\entity\restaurant\Comments
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
				 * @var models\entity\restaurant\Comments
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
	 * Member like the comment / reply
	 *
	 * @param		identity Can use ID, UUID or username.
	 */
	public function commentLike($identity)
	{
		// Set html header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		/**
		 * @var models\entity\restaurant\Comments
		 */
		$comment = $this->_loadComment($identity);

		$success = false;

		if ($this->member->isLogin($this->session) && !empty($comment))
		{
			/**
			 * @var models\entity\member\Members
			 */
			$member = $this->member->getLoginMember($this->session);
			$like = $comment->getLike();

			if ($like->contains($member))
			{
				$like->removeElement($member);
			}
			else
			{
				$like->add($member);
			}

			$this->comment->save($comment);

			$success = true;
		}
		echo json_encode($success);
	}

	/**
	 * Load restaurant from identity
	 *
	 * @param		identity identity Can use ID, UUID or username.
	 */
	private function _loadRestaurant($identity)
	{
		$identity = trim($identity);

		$this->load->library('uuid');
		$restaurant = null;

		if ($this->uuid->is_valid($identity))
		{
			$restaurant = $this->restaurant->getItem($identity, 'uuid');
		}
		elseif ((int)$identity > 0 && self::IDENTITY_SELECT_ID)
		{
			// integer
			$restaurant = $this->restaurant->getItem((int)$identity);
		}
		elseif (preg_match('/^\w+$/', $identity))
		{
			// match [0-9a-zA-Z_]+
			$restaurant = $this->restaurant->getItem($identity, 'username');
		}

		return $restaurant;
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
