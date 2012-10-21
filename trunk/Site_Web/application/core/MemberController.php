<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('./MY_Controller.php');

class MemberController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		/*
		Desactiver pour le moment...
		if($this->session->userdata('is_connected') != 1 && $this->session->userdata('user') != NULL)
		{
			parent::show403Error(); 
		}
		*/
	}
}

?>