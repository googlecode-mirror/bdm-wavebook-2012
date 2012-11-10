<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends MemberController
{
	/**
	* Constructeur
	*/
	public function __construct()
	{
		parent::__construct();
		
		//On change le titre de la page
		parent::setPageName('Profils');
		
		//On change la vue du menu
		parent::setMenuView('menu/profil_menu');
	}

	public function view($user_id = NULL)
	{
		if($user_id == NULL)
		{		
			$user = unserialize($this->session->userdata('user_obj'));
		}
		else if(is_numeric($user_id))
		{
			$user = User::getUserById($user_id);

			if($user == NULL)
			{
				parent::show404Error();
			}
			
			//On change la vue du menu
			parent::setMenuView('menu/profils_menu');
		}
		else
		{
			parent::show404Error();
		}

		parent::loadHeader();

		$data = array();
		$data['user'] = $user;
		$this->load->view('profil/index', $data);

		parent::loadFooter();
		
	}

	public function index()
	{
		$this->view();
	}
}
