<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flux extends MemberController
{
	/**
	* Constructeur
	*/
	public function __construct()
	{
		parent::__construct();
		
		//On change le titre de la page
		parent::setPageName('Flux d\'actualités');
		
		//On change la vue du menu
		parent::setMenuView('menu/flux_menu');
	}

	public function index()
	{
		parent::loadHeader();
		$this->load->view('flux/flux_index');
		parent::loadFooter();
	}
}