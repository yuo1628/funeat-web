<?php defined('BASEPATH') or exit('No direct script access allowed');

use models\FuneatFactory;
use models\Member as MemberModel;
use models\Restaurant as RestaurantModel;
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
		/**
		 * @var models\Restaurant
		 */
		$restaurant = $this->getModel('Restaurant');

		// Add style sheet
		$this->head->addStyleSheet('css/gallery.css');
		$this->head->addStyleSheet('css/restaurant_list.css');

		$this->setData('restaurants', $restaurant->getItems());

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

		/**
		 * @var models\Restaurant
		 */
		$restaurant = $this->getModel('Restaurant');

		$range = $this->input->post('range');
		$range = $range === false ? RestaurantModel::NEAREST_DEFAULT_RANGE : (float)$range;

		$offset = $this->input->post('offset');
		$offset = $offset === false ? 0 : (int)$offset;

		$limit = $this->input->post('limit');
		$limit = $limit === false ? 10 : (int)$limit;

		$items = $restaurant->getItemsByNearest($lat, $lng, $offset, $limit, $range);

		foreach ($items as $i => $item)
		{
			/**
			 * @var	models\entity\restaurant\Restaurants
			 */
			$item;

			$items[$i] = $item->toArray(true);
		}

		echo json_encode($items);
	}

	/**
	 * Randomly select
	 *
	 * @param		float	$num		Number.
	 *
	 * @return		JSON	data of list
	 */
	public function random($num = 1)
	{
		// Set header
		header('Cache-Control: no-cache');
		header('Content-type: application/json');

		/**
		 * @var models\Restaurant
		 */
		$restaurant = $this->getModel('Restaurant');

		$items = $restaurant->getItemsByRandomly($num);

		foreach ($items as $i => $item)
		{
			/**
			 * @var	models\entity\restaurant\Restaurants
			 */
			$item;

			$items[$i] = $item->toArray(true);
		}

		echo json_encode($items);
	}

	/**
	 * Restaurant profile page
	 *
	 * @param		identity Can use ID, UUID or username.
	 */
	public function profile($identity, $format = self::OUTPUT_FORMAT_HTML)
	{
		$item = FuneatFactory::getRestaurant($identity);

		if (empty($item))
		{
			$this->load->helper('url');

			redirect('restaurant', 'location', 301);
		}
		else
		{
			switch ($format)
			{
				default :
				case self::OUTPUT_FORMAT_HTML :
					// Set output data
					$this->setData('restaurant', $item);
					$this->setData('member', FuneatFactory::getMember());

					// Add stylesheets & scripts
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
	}

	/**
	 * Add action
	 */
	public function add()
	{
		if (FuneatFactory::isLogin())
		{
			$this->load->helper('form');

			/**
			 * @var models\Feature
			 */
			$featureModel = $this->getModel('Feature');

			$this->setData('features', $featureModel->getItems());
			$this->setData('restaurant', FuneatFactory::getRestaurantInstance());
			

			// Add stylesheets & scripts
			$this->head->addStyleSheet('css/gallery.css');
			$this->head->addStyleSheet('css/restaurant_edit.css');
			$this->head->addScript('js/restaurant_edit.js');

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
		if (FuneatFactory::isLogin())
		{
			$this->load->helper('form');

			/**
			 * @var models\Feature
			 */
			$featureModel = $this->getModel('Feature');

			$this->setData('features', $featureModel->getItems());
			$this->setData('restaurant', FuneatFactory::getRestaurant($identity));

			// Add stylesheets & scripts
			$this->head->addStyleSheet('css/gallery.css');
			$this->head->addStyleSheet('css/restaurant_edit.css');
			$this->head->addScript('js/restaurant_edit.js');

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
				$restaurant = FuneatFactory::getRestaurantInstance();
			}
		}
		else
		{
			// Load restaurant data when identity is not null.
			$identity = trim($identity);

			$restaurant = FuneatFactory::getRestaurant($identity);
		}

		// It not vaild when restaurant is null
		if (FuneatFactory::isLogin() && !empty($restaurant))
		{
			/**
			 * @var models\Restaurant
			 */
			$restaurantModel = $this->getModel('Restaurant');

			/**
			 * Load creator
			 *
			 * @var models/entity/member/Members
			 */
			$creator = FuneatFactory::getMember();

			// Assign normal data
			$restaurant->setName($this->input->post('name'));
			$restaurant->setAddress($this->input->post('address'));
			$restaurant->setIntro($this->input->post('intro'));
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
			 * @var models\Feature
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
			$restaurantModel->save($restaurant);

			// After save data
			$this->load->helper('url');

			redirect('/restaurant/' . $restaurant->getUuid(), 'location', 301);
		}
		else
		{
			if (!FuneatFactory::isLogin())
			{
				$this->load->helper('url');

				redirect('/login', 'location', 301);
			}
			else if ($identity === null)
			{
				/**
				 * @var models\Feature
				 */
				$featureModel = $this->getModel('Feature');

				$this->load->helper('form');

				$this->setData('features', $featureModel->getItems());
				$this->view('restaurant/add');
			}
			else
			{
				/**
				 * @var models\Feature
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
		 * @var models\Restaurant
		 */
		$restaurantModel = $this->getModel('Restaurant');

		/**
		 * @var models\entity\restaurant\Restaurants
		 */
		$restaurant = FuneatFactory::getRestaurant($identity);

		$success = false;

		if (FuneatFactory::isLogin() && !empty($restaurant))
		{
			$member = FuneatFactory::getMember();

			if (!$restaurant->like->contains($member))
			{
				if ($restaurant->dislike->contains($member))
				{
					$restaurant->dislike->removeElement($member);
				}
				$restaurant->like->add($member);
				$restaurantModel->save($restaurant);
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
		 * @var models\Restaurant
		 */
		$restaurantModel = $this->getModel('Restaurant');

		/**
		 * @var models\entity\restaurant\Restaurants
		 */
		$restaurant = FuneatFactory::getRestaurant($identity);

		$success = false;

		if (FuneatFactory::isLogin() && !empty($restaurant))
		{
			$member = FuneatFactory::getMember();
			;

			if (!$restaurant->dislike->contains($member))
			{
				if ($restaurant->like->contains($member))
				{
					$restaurant->like->removeElement($member);
				}
				$restaurant->dislike->add($member);
				$restaurantModel->save($restaurant);
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
		 * @var models\Feature
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
		$item = FuneatFactory::getRestaurant($identity);

		$success = false;

		if (FuneatFactory::isLogin() && !empty($item))
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

				// TODO How to decide type?
				$type = Comments::TYPE_MEMBER;

				$comment->setComment($this->input->post('comment'));
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

		if (FuneatFactory::isLogin() && !empty($reply))
		{
			// Set rules
			$this->form_validation->set_rules('comment', 'Comment', 'required');

			if ($this->form_validation->run() == true)
			{
				/**
				 * @var models\entity\restaurant\Comments
				 */
				$comment = $commentModel->getInstance();

				// TODO How to decide type?
				$type = Comments::TYPE_MEMBER;

				$comment->setComment($this->input->post('comment'));
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

		if (FuneatFactory::isLogin() && !empty($comment))
		{
			/**
			 * @var models\entity\member\Members
			 */
			$member = FuneatFactory::getMember();

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
