<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CSS loading controller
 *
 * @author		Miles <jangconan@gmail.com>
 */
class Css extends MY_Controller
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		// Do not use database
		parent::__construct('default', self::DATABASE_LIBRARY_NONE);
	}

	/**
	 * Default
	 *
	 * @param		$type
	 */
	public function index($type = 'params')
	{
		// Set header
		header('Content-type: text/css');

		$root = $this->input->get('root');

		if (!preg_match('/^css\//', $root) && !preg_match('/^media\/fun\//', $root))
		{
			$root = 'css/';
		}

		$type = in_array($type, array(
			'default',
			'params'
		)) ? $type : 'default';

		$file = $this->input->get('file');

		switch ($type)
		{
			default :
			case 'default' :
				echo $this->getInclude($root . $file . '.php');
				break;

			case 'css' :
				echo $this->getInclude($root . $file . '.css');
				break;
		}
	}

}
