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
	
	public function register_validation()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>');
			
		//mise en place des regles
		$this->form_validation->set_rules('name', 'Nom', 'required|encode_php_tags|htmlspecialchars|trim|xss_clean|max_length[20]');
		$this->form_validation->set_rules('vorname', 'Prénom', 'required|encode_php_tags|htmlspecialchars|trim|xss_clean|max_length[20]');
		$this->form_validation->set_rules('password', 'Mot de passe', 'required|alpha|max_length[20]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]');
		$this->form_validation->set_rules('sexe', 'Sexe', 'required|matches[sexe]');
		//$this->form_validation->set_rules('avatar', 'Avatar', 'required');
			
		if ($this->form_validation->run() == FALSE) // echec
		{
			//on affiche le formulaire
			$this->register();
		}
		else // reussite
		{
			//creation de l'utilisateur
			$user = new User();
			$user->name = $this->input->post('name');
			$user->vorname = $this->input->post('vorname');
			$user->password = strtolower($this->input->post('password'));
			$user->email = $this->input->post('email');
			if($this->input->post('sexe') == "Femme") $user->sex = 0;
			else $user->sex = 1;
			
			//sauvegarde de l'utilisateur
			$user->save();
			
			// upload de l'avatar
			$avatar_up = new Upload();
			if($avatar_up->upload_avatar($user->id))
			{
				//Verification de la conformité de l'avatar
				// appel FaceDetection...

				//Enregistrement dans la BDD
				$new_avatar = new Avatar();
				$new_avatar->url = $avatar_up->filename;
				$new_avatar->id_user = $user->id;
				$new_avatar->save();
				
				//notification
				$this->session->set_userdata('notif_ok','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Inscription réussite!</strong> Vous pouvez maintenant vous connecter au site !</div>');
				
				//redirection sur l'accueil
				redirect('home/index','refresh');
			}
			else
			{
				//on supprime l'utilisateur et son espace de travail
				$user->delete();
				
				//on affiche le formulaire
				$this->register();
			}
		}
	}
	
	/**
	 * Page d'inscription d'un nouvel user
	 */
	public function register()
	{
			//On change la vue du menu
			parent::setMenuView('menu/register_menu');
		
			parent::loadHeader();
			
			$this->load->view('notification_zone');
			$data['ruser'] = User::getRandomUsers(4);
			$this->load->view('home/register', $data);
			
			parent::loadFooter();
	}

	/**
	 * Page d'accueil
	 */
	public function index()
	{
		parent::loadHeader();
		
		$this->load->view('notification_zone');
		
		$data['ruser'] = User::getRandomUsers(4);
		$this->load->view('home/index', $data);
		
		parent::loadFooter();
	}

}
