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
	 * @param		$path		Don't include the ext.
	 */
	public function index($type = 'dynamic')
	{
		$root = $this->input->get('root');

		if (!preg_match('/^css\//', $root) && !preg_match('/^media\/fun\//', $root))
		{
			$root = 'css/';
		}

		$type = in_array($type, array(
			'css',
			'dynamic'
		)) ? $type : 'dynamic';

		$file = $this->input->get('file');

		switch ($type)
		{
			case 'css' :
				if (is_file($root . $file . '.css'))
				{
					header('Content-type: text/css');
					include $root . $file . '.css';
				}
				break;

			case 'dynamic' :
				if (is_file($root . $file . '.php'))
				{
					header('Content-type: text/css');
					include $root . $file . '.php';
				}
				break;
		}
	}

}
