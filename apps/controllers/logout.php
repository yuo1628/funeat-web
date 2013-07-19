<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
		parent::__construct('default');
    }

	/**
	 * Main action
	 */
	public function index()
	{
		$this->load->library('session');
		$this->session->sess_destroy();
	}
}
