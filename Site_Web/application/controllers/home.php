<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends GuestController
{
	/**
	* Constructeur
	*/
	public function __construct()
	{
		parent::__construct();
		
		//On change le titre de la page
		parent::setPageName('Accueil');
		
		//On change la vue du menu
		parent::setMenuView('menu/home_menu');
	}

	public function index()
	{
		parent::loadHeader();
		$this->load->view('home/index');
		parent::loadFooter();
	}
}
