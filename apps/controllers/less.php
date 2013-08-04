<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CSS loading controller
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
		parent::__construct('default', self::DATABASE_LIBRARY_NONE);
	}

	/**
	 * Default
	 *
	 * @param		$path		Don't include the ext.
	 */
	public function index()
	{
		$root = $this->input->get('root');

		if (!preg_match('/^css\//', $root) && !preg_match('/^media\/fun\//', $root))
		{
			$root = 'css/';
		}

		$file = $this->input->get('file');

		$this->load->library('lessc');

		if (is_file($root . $file . '.less'))
		{
			$less = $root . $file . '.less';
			$lessCache = $less . '.cache';
			$cache = (is_file($lessCache)) ? unserialize(file_get_contents($lessCache)) : $less;
			$newCache = Lessc::cexecute($cache);

			if (!is_array($cache) || $newCache['updated'] > $cache['updated'])
			{
				file_put_contents($lessCache, serialize($newCache));
			}

			header('Content-type: text/css');

			echo $newCache['compiled'];
		}
	}

}
