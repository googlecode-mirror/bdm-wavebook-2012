<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('./MY_Controller.php');

class GuestController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		//Redirection si connecté
		if($this->session->userdata('is_connected') == 1 && $this->session->userdata('user_obj') != NULL)
		{
			redirect('flux/index','refresh');
		}
	}
}

?>
