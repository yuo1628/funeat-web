<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * LESS loading controller
 *
 * @author		Miles <jangconan@gmail.com>
 */
class Less extends MY_Controller
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
	public function index()
	{
		// Set header
		header('Content-type: text/css');

		$root = $this->input->get('root');

		if (!preg_match('/^less\//', $root) && !preg_match('/^media\/fun\//', $root))
		{
			$root = 'less/';
		}

		$file = $this->input->get('file');

		$this->load->library('lessc');

		$less = $root . $file . '.less';
		$lessCache = $less . '.cache';
		$cache = (is_file($lessCache)) ? unserialize(file_get_contents($lessCache)) : $less;
		$newCache = Lessc::cexecute($cache);

		if (!is_array($cache) || $newCache['updated'] > $cache['updated'])
		{
			file_put_contents($lessCache, serialize($newCache));
		}

		echo $newCache['compiled'];
	}

}
