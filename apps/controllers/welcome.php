<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		$this->view('welcome_message');
	}
}
