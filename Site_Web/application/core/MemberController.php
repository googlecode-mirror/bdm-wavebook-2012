<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('./MY_Controller.php');

class MemberController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		// Test uniquement !
		$this->session->set_userdata('user_obj', serialize(User::getUserById(12)));
		$this->session->set_userdata('is_connected',1);

		/*
		Desactiver pour le moment...
		if($this->session->userdata('is_connected') != 1 && $this->session->userdata('user_obj') != NULL)
		{
			parent::show403Error(); 
		}
		*/
	}
}

?>
