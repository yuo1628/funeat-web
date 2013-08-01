<?php defined('BASEPATH') or exit('No direct script access allowed');

use models\Member as MemberModel;
use models\entity\restaurant\Comments as Comments;
use models\entity\image\Images as Images;

/**
 * Restaurant
 *
 * @author		Miles <jangconan@gmail.com>
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
	protected $restaurantModel;

	/**
	 * @var models\Feature
	 */
	//protected $feature;

	/**
	 * @var models\Member
	 */
	//protected $member;

	/**
	 * @var models\Comment
	 */
	//protected $comment;

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
		$this->restaurantModel = $this->getModel('Restaurant');
	}

	/**
	 * Index page
	 *
	 * @return		HTML
	 */
	public function index()
	{
		// Add style sheet
		$this->head->addStyleSheet('css/gallery.css');
		$this->head->addStyleSheet('css/restaurant_list.css');

		$this->setData('restaurants', $this->restaurantModel->getItems());

		$this->view('restaurant/list');
	}

	/**
	 * Query for list
	 *
	 * @param		float	lat			Latitude of local position.
	 * @param		float	lng			Longitude of local position.
	 *
	 * @param		float	distance	Distance of meter.
	 *
	 * @return		JSON	data of list
	 */
	public function query($lat, $lng)
	{
		// Set header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		$this->load->library('Maps');

		/**
		 * @var Maps
		 */
		$maps = $this->maps;

		$distance = (float)$this->input->get('distance');

		$items = $this->restaurantModel->getItems();

		$output = array();

		foreach ($items as $i => $item)
		{
			/**
			 * @var	models\entity\restaurant\Restaurants
			 */
			$item;

			if ($distance)
			{
				$item->setDistance($lat, $lng);
				if ($item->getDistance() > $distance)
				{
					unset($items[$i]);
					continue;
				}
			}

			$output[] = $item->toArray(true);
		}

		echo json_encode($output);
	}

	/**
	 * Restaurant profile page
	 *
	 * @param		identity Can use ID, UUID or username.
	 */
	public function profile($identity, $format = self::OUTPUT_FORMAT_HTML)
	{
		$item = $this->restaurantModel->getItemByIdentity($identity);

		$member = null;

		if (MemberModel::isLogin($this->session) && !empty($item))
		{
			/**
			 * @var models\Member
			 */
			$memberModel = $this->getModel('Member');

			$member = $memberModel->getLoginMember($this->session);
		}

		switch ($format)
		{
			default :
			case self::OUTPUT_FORMAT_HTML :
				$this->setData('restaurant', $item);
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

				if ($item === null)
				{
					echo json_encode(null);
				}
				else
				{
					echo json_encode($item->toArray(true));
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
		if (MemberModel::isLogin($this->session))
		{
			$this->load->helper('form');

			/**
			 * @var models\Member
			 */
			$featureModel = $this->getModel('Feature');

			$this->setData('features', $featureModel->getItems());
			$this->setData('restaurant', $this->restaurantModel->getInstance());

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
	 *
	 * @param		identity Can use ID, UUID or username.
	 */
	public function edit($identity)
	{
		if (MemberModel::isLogin($this->session))
		{
			$this->load->helper('form');

			/**
			 * @var models\Member
			 */
			$featureModel = $this->getModel('Feature');

			$this->setData('features', $featureModel->getItems());
			$this->setData('restaurant', $this->restaurantModel->getItemByIdentity($identity));

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
				$restaurant = $this->restaurantModel->getInstance();
			}
		}
		else
		{
			// Load restaurant data when identity is not null.
			$identity = trim($identity);

			$restaurant = $this->restaurantModel->getItemByIdentity($identity);
		}

		// It not vaild when restaurant is null
		if (MemberModel::isLogin($this->session) && !empty($restaurant))
		{
			// Do data saving

			/**
			 * @var models\Member
			 */
			$memberModel = $this->getModel('Member');

			/**
			 * Load creator
			 *
			 * @var models/entity/member/Members
			 */
			$creator = $memberModel->getLoginMember($this->session);

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

			/**
			 * @var models\Member
			 */
			$featureModel = $this->getModel('Feature');

			$restaurant->setFeatures($this->input->post('features'), $featureModel);

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
			$this->restaurantModel->save($restaurant);

			// After save data
			$this->load->helper('url');

			redirect('/restaurant/' . $restaurant->getUuid(), 'location', 301);
		}
		else
		{
			if (!$memberModel->isLogin($this->session))
			{
				$this->load->helper('url');

				redirect('/login', 'location', 301);
			}
			else if ($identity === null)
			{
				/**
				 * @var models\Member
				 */
				$featureModel = $this->getModel('Feature');

				$this->load->helper('form');

				$this->setData('features', $featureModel->getItems());
				$this->view('restaurant/add');
			}
			else
			{
				/**
				 * @var models\Member
				 */
				$featureModel = $this->getModel('Feature');

				$this->load->helper('form');

				$this->setData('features', $featureModel->getItems());
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
		$restaurant = $this->restaurantModel->getItemByIdentity($identity);

		$success = false;

		if (MemberModel::isLogin($this->session) && !empty($restaurant))
		{

			/**
			 * @var models\Member
			 */
			$memberModel = $this->getModel('Member');

			$member = $memberModel->getLoginMember($this->session);

			if (!$restaurant->like->contains($member))
			{
				if ($restaurant->dislike->contains($member))
				{
					$restaurant->dislike->removeElement($member);
				}
				$restaurant->like->add($member);
				$this->restaurantModel->save($restaurant);
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
		$restaurant = $this->restaurantModel->getItemByIdentity($identity);

		$success = false;

		if (MemberModel::isLogin($this->session) && !empty($restaurant))
		{
			/**
			 * @var models\Member
			 */
			$memberModel = $this->getModel('Member');

			$member = $memberModel->getLoginMember($this->session);

			if (!$restaurant->dislike->contains($member))
			{
				if ($restaurant->like->contains($member))
				{
					$restaurant->like->removeElement($member);
				}
				$restaurant->dislike->add($member);
				$this->restaurantModel->save($restaurant);
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

		/**
		 * @var models\Member
		 */
		$featureModel = $this->getModel('Feature');

		// Output default value
		$output = null;

		switch ($action)
		{
			default :
			case self::FEATURE_ACTION_LIST :
				$list = $featureModel->getItems();
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
					$duplicate = $featureModel->getItem($title, 'title');

					if (empty($duplicate))
					{
						$parent = (int)$this->input->post('parent');

						$data = $featureModel->getInstance();
						$data->setTitle(trim($this->input->post('title')));

						if ($parent !== 0)
						{
							$parentItem = $featureModel->getItem($parent);
							$data->setParent($parentItem);
						}

						$featureModel->save($data);

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
					$item = $featureModel->getItem($id);

					if (!empty($item))
					{
						$parent = (int)$this->input->post('parent');

						$item->setTitle(trim($this->input->post('title')));

						if ($parent !== 0)
						{
							$parentItem = $featureModel->getItem($parent);
							$item->setParent($parentItem);
						}

						$featureModel->save($item);

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
					$item = $featureModel->getItem($id);

					$featureModel->remove($item);

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
		$item = $this->restaurantModel->getItemByIdentity($identity);

		$success = false;

		if (MemberModel::isLogin($this->session) && !empty($item))
		{
			// Set rules
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');

			if ($this->form_validation->run() == true)
			{
				/**
				 * @var models\restaurant\Comment
				 */
				$commentModel = $this->getModel('restaurant\\Comment');

				/**
				 * @var models\entity\restaurant\Comments
				 */
				$comment = $commentModel->getInstance();

				/**
				 * @var models\Member
				 */
				$memberModel = $this->getModel('Member');

				/**
				 * @var models\entity\member\Members
				 */
				$member = $memberModel->getLoginMember($this->session);

				// TODO How to decide type?
				$type = Comments::TYPE_MEMBER;

				$comment->setComment($this->input->post('comment'));
				$comment->setCreator($member, $type);
				$comment->setRestaurant($item);

				$commentModel->save($comment);

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
		 * @var models\restaurant\Comment
		 */
		$commentModel = $this->getModel('restaurant\\Comment');

		/**
		 * @var models\entity\restaurant\Comments
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
				 * @var models\entity\restaurant\Comments
				 */
				$comment = $commentModel->getInstance();

				/**
				 * @var models\Member
				 */
				$memberModel = $this->getModel('Member');

				/**
				 * @var models\entity\member\Members
				 */
				$member = $memberModel->getLoginMember($this->session);

				// TODO How to decide type?
				$type = Comments::TYPE_MEMBER;

				$comment->setComment($this->input->post('comment'));
				$comment->setCreator($member, $type);
				$comment->setReply($reply);

				$commentModel->save($comment);

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
		 * @var models\restaurant\Comment
		 */
		$commentModel = $this->getModel('restaurant\\Comment');

		/**
		 * @var models\entity\restaurant\Comments
		 */
		$comment = $commentModel->getItemByIdentity($identity);

		$success = false;

		if (MemberModel::isLogin($this->session) && !empty($comment))
		{
			/**
			 * @var models\Member
			 */
			$memberModel = $this->getModel('Member');

			/**
			 * @var models\entity\member\Members
			 */
			$member = $memberModel->getLoginMember($this->session);
			$like = $comment->getLike();

			if ($like->contains($member))
			{
				$like->removeElement($member);
			}
			else
			{
				$like->add($member);
			}

			$commentModel->save($comment);

			$success = true;
		}

		echo json_encode($success);
	}

}
