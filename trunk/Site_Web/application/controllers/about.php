<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends GuestController
{
	/**
	* Constructeur
	*/
	public function __construct()
	{
		parent::__construct();
		
		//On change le titre de la page
		parent::setPageName('A propos');
		
		//On change la vue du menu
		parent::setMenuView('menu/about_menu');
	}

	public function index()
	{
		parent::loadHeader();
		$this->load->view('about/index');
		parent::loadFooter();
	}
}