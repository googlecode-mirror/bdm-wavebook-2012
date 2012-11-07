<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends GuestController
{
	/**
	* Constructeur
	*/
	public function __construct()
	{
		parent::__construct();
		
		//On change le titre de la page
		parent::setPageName('Erreur');
		
		//On change la vue du menu
		parent::setMenuView('menu/error_menu');
	}
	
	public function error404()
	{
		parent::loadHeader();
		$this->load->view('error/error404');
		parent::loadFooter();
	}
	
	public function error403()
	{
		parent::loadHeader();
		$this->load->view('error/error403');
		parent::loadFooter();
	}
	
}
