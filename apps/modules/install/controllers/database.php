<?php if ( ! defined('BASEPATH') || ENVIRONMENT != 'development') exit('No direct script access allowed');

class Database extends MX_Controller
{
	protected $_entity = array(
		'models\\entity\\collection\\Collections',
		'models\\entity\\collection\\Points',
		'models\\entity\\collection\\Templates',
		'models\\entity\\store\\Commodities',
		'models\\entity\\store\\Stores',
		'models\\entity\\store\\Storegroups',
		'models\\entity\\member\\Members',
		'models\\entity\\member\\Membergroups'
	);

	public function index()
	{
		$this->load->helper('url');
		$data = array();
		$data['entity'] = $this->_entity;

		$this->load->view('database_index', $data);
	}

	public function install()
	{
		$this->load->library('doctrine');
		$this->doctrine->tool->createSchema($this->getClassMetadataArray());
		echo 'Schema created!!';
	}

	public function update()
	{
		$this->load->library('doctrine');
		$this->doctrine->tool->updateSchema($this->getClassMetadataArray());
		echo 'Schema updated!!';
	}

	public function drop()
	{
		$this->load->library('doctrine');
		$this->doctrine->tool->dropSchema($this->getClassMetadataArray());
		echo 'Schema droped!!';
	}

	private function getClassMetadataArray()
	{
		$entity = array();
		foreach ($this->_entity as $value)
		{
			$entity[] = $this->doctrine->em->getClassMetadata($value);
		}
		return $entity;
	}
}
