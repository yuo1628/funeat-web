<?php defined('BASEPATH') or exit('No direct script access allowed');

use models\Feature as FeatureModel;
use models\entity\restaurant\Features;

/**
 * Restaurant
 *
 * @author		Miles <jangconan@gmail.com>
 */
class Feature extends MY_Controller
{
	/**
	 * @var models\Feature
	 */
	protected $featureModel;

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
		$this->featureModel = $this->getModel('Feature');
	}

	/**
	 * Index page
	 *
	 * @return		HTML
	 */
	public function index()
	{
		// Add style sheet
		$this->setData('features', $this->featureModel->getItems());
		$this->head->addStyleSheet('css/feature_list.css');

		$this->view('feature/list');
	}

	/**
	 * Add action
	 */
	public function add()
	{
		// TODO: Do auth and set creator

		if (true)
		{
			$this->head->addStyleSheet('css/feature_add.css');
			$this->view('feature/edit');
		}
		else
		{
			$this->load->helper('url');
			redirect('feature', 'location', 301);
		}
	}

	/**
	 * Edit action
	 */
	public function edit($id)
	{
		$id = (int)$id;
		$feature = $this->featureModel->getItem($id);

		// TODO: Do auth and set creator

		if ($feature)
		{
			$this->setData('feature', $feature);
			$this->head->addStyleSheet('css/feature_add.css');
			$this->view('feature/edit');
		}
		else
		{
			$this->load->helper('url');
			redirect('feature', 'location', 301);
		}
	}

	/**
	 * Save action
	 */
	public function save($id = null)
	{
		// TODO: Do auth

		/**
		 * @var		models\entity\restaurant\Features
		 */
		$feature = null;

		if ($id === null)
		{
			// Set rules
			$this->form_validation->set_rules('title', 'Title', 'required');

			if ($this->form_validation->run() == true)
			{
				$feature = $this->featureModel->getInstance();
			}
		}
		else
		{
			$feature = $this->featureModel->getItem((int)$id);
		}

		if (!empty($feature))
		{
			$title = trim($this->input->post('title'));
			$duplicate = $this->featureModel->getItem($title, 'title');

			if ($id || empty($duplicate))
			{
				$parent = (int)$this->input->post('parent');
				$feature->setTitle(trim($this->input->post('title')));
				$feature->setHoursMapping((int) $this->input->post('hoursMapping'));

				if ($parent !== 0)
				{
					$parentItem = $this->featureModel->getItem($parent);
					$feature->setParent($parentItem);
				}

				// Assign upload image data
				$this->load->library('upload', Features::$UPLOAD_CONFIG);

				/**
				 * @var MY_Upload
				 */
				$upload = $this->upload;

				if ($upload->do_upload('icon'))
				{
					$data = $upload->data();

					if ($data['is_image'])
					{
						$feature->setIcon($data['full_path']);

						$this->featureModel->save($feature);

						$this->load->helper('url');
						redirect('feature', 'location', 301);
					}
					else
					{
						$this->load->helper('file');
						delete_files($data['full_path']);

						$this->view('feature/edit');
					}
				}
				else
				{
					if ($id === null)
					{
						$this->head->addStyleSheet('css/feature_add.css');
						$this->view('feature/edit');
					}
					else
					{
						$this->featureModel->save($feature);
						$feature->onPostUpdate();
						$this->load->helper('url');
						redirect('feature', 'location', 301);
					}
				}
			}
			else
			{
				$this->head->addStyleSheet('css/feature_add.css');
				$this->view('feature/edit');
			}
		}
		else
		{
			$this->head->addStyleSheet('css/feature_add.css');
			$this->view('feature/edit');
		}
	}

	/**
	 * delete action
	 */
	public function delete($id)
	{
		$id = (int)$id;

		$this->load->library('form_validation');

		// TODO: Do auth

		if ($id > 0)
		{
			$item = $this->featureModel->getItem($id);

			$this->featureModel->remove($item);
		}
		else
		{
			$this->load->helper('url');
			redirect('feature/list', 'location', 301);
		}
	}

}
