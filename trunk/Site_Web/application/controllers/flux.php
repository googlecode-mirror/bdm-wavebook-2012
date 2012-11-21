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

		//Requete SQL
		$files = File::getFilesByPage();

		//Fabriquer tableau
		$data['files'] = $files;
		$this->load->view('notification_zone');
		$this->load->view('flux/flux_index', $data);	

		parent::loadFooter();
	}

	
	public function share()
	{
		//On change le titre de la page
		parent::setPageName('Partager');
		
		parent::loadHeader();

		$this->load->view('notification_zone');
		$this->load->view('flux/flux_share');

		parent::loadFooter();
	}

	public function share_validation()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>');

		//mise en place des regles
		$this->form_validation->set_rules('keywords', 'Mots-clés', 'required|encode_php_tags|htmlspecialchars|trim|xss_clean|max_length[200]');
		$this->form_validation->set_rules('description', 'Description', 'required|encode_php_tags|htmlspecialchars|trim|xss_clean|max_length[300]');

		if ($this->form_validation->run() == FALSE) // echec
		{
			//on affiche le formulaire
			$this->share();
		}
		else // reussite
		{
			// upload du fichier
			$file_up = new Upload();
			$user = unserialize($this->session->userdata('user_obj'));
			
			if($file_up->upload_file($user->id, array('userfile')))
			{
				// Création fichier
				$file = new File();
				$file->id_user = $user->id;
				$file->desc = $this->input->post('description');
				$file->keywords = $this->input->post('keywords');
				$file->url = $file_up->files_uploaded[0][0];
				$file->type = $file_up->files_uploaded[0][1];

				//sauvegarde du fichier
				$file->save();
				
				//notification
				$this->session->set_userdata('notif_ok','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Bravo! </strong> Votre partage a été réussi.</div>');
			
				//redirection sur l'actualité
				redirect('flux','refresh');
			}
			else
			{				
				//on affiche le formulaire
				$this->share();
			}
		}
	}
}
