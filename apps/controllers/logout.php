<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Logout function
 *
 * @author		Miles <jangconan@gmail.com>
 */
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
