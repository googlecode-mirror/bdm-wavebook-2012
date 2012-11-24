<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller 
{
	protected $site_title;
	protected $site_description;
	protected $site_keywords;
	protected $site_revision;
	protected $site_year;
	protected $site_author;
	protected $current_page;
	protected $menu_view;
	
	
    public function __construct()
    {
        parent::__construct();
		
		$this->site_title = 'WaveBook';
		$this->site_description = 'WaveBook est une plateforme permettant de partager vos fichiers multimédias (musiques, photos, vidéos, documents) avec le monde entier en quelques clics !';
		$this->site_keywords = 'wavebook, reconnaissance faciale, bdm, education, banque de données, partage, social, upload';
		$this->site_revision = '21102012';
		$this->site_author = 'BDMTeam';
		$this->current_page = 'Index';
		$this->site_year = 2012;
		$this->menu_view = 'menu/home_menu';
    }
	
	public function setPageName($name)
	{
		$this->current_page = ucfirst($name);
	}

	public function setDescription($desc)
	{
		$this->site_description = ucfirst($desc);
	}

	public function setKeywords($tags)
	{
		$this->site_keywords = $tags;
	}
	
	public function setMenuView($view)
	{
		$this->menu_view = $view;
	}
	
	public function loadHeader()
	{
		$data = array();
		$data['title'] = $this->current_page . ' - ' . $this->site_title;
		$data['desc'] = $this->site_description;
		$data['keywords'] = $this->site_keywords;
		$data['last_revision'] = $this->site_revision;
		$data['author'] = $this->site_author;
		
		$this->load->view('header', $data);
		$this->load->view($this->menu_view);
	}
	
	public function loadFooter()
	{
		$data = array();
		$data['title'] =  $this->site_title;
		$data['author'] = $this->site_author;
		$data['current_year'] = $this->site_year;
		
		$this->load->view('footer', $data);
	}
	
	public function show404Error()
	{
		redirect('error/error404','refresh');
	}
	
	public function show403Error()
	{
		redirect('error/error403','refresh');
	}
	
/*
	public function _remap($method)
	{
		//$this->show404Error();
		//$this->showMaintenance();
		//$this->show403Error();
	}*/
}

?>
