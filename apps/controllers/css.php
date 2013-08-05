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
	 */
	public function index()
	{
		// Set header
		header('Content-type: text/css');

		$root = $this->input->get('root');

		if (!preg_match('/^css\//', $root) && !preg_match('/^media\/fun\//', $root))
		{
			$root = 'css/';
		}

		$file = $this->input->get('file');

		$params = $this->input->get();
		echo $this->getInclude($root . $file . '.css', $params);
	}

}
