<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Welcome function
 *
 * @author		Miles <jangconan@gmail.com>
 */
class Welcome extends MY_Controller
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('default');
	}

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$this->view('welcome/default');
	}
}
