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
		$this->form_validation->set_rules('cgu', 'Conditions générales d\'utilisation', 'required');
		
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

				//Enregistrement dans la BDD de chaque avatar
				//print_r($avatar_up->files_uploaded);
				for($i = 0; $i < count($avatar_up->files_uploaded); $i++)
				{
					$new_avatar = new Avatar();
					$new_avatar->url = $avatar_up->files_uploaded[$i][0];
					$new_avatar->id_user = $user->id;
					$new_avatar->save();
				}
				
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
	
	public function login_validation()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>');
			
		//mise en place des regles
		$this->form_validation->set_rules('password', 'Mot de passe', 'required|alpha|max_length[20]');
		$password_ok = false;
		
		if ($this->form_validation->run() != FALSE) // reussite
		{
			
			// upload de l'image de connexion
			$co_up = new Upload();
			if($co_up->upload_tmp_file(array('userfile')))
			{	
				// Appel distant de FaceReconnaizion
				exec('(cd ../Reconnaissance_Faciale/ ; make run ARG=1 IMG='.Upload::$upload_tmp_directory . '/' . $co_up->files_uploaded[0][0].')', $output, $return);
				//print_r($output);
				//echo $return;
				
				
				if(is_numeric($return))
				{
						// On récupere l'utilisateur détecté
						$user_detected = User::getUserById($return);
						
						// Securité : on verifie que l'utilisateur detecte existe deja
						if($user_detected != NULL)
						{
							// Vérification du mot de passe
							if(strtolower($this->input->post('password')) == strtolower($user_detected->password))
							{
								//Notification de réussite
								$this->session->set_userdata('notif_ok','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Connexion réussite !</strong> Bienvenue '.$user_detected->name .' '.$user_detected->vorname.'.</div>');
								$password_ok = true;
								
								//Mise en place de la session
								$this->session->userdata('user_obj',  serialize($user_detected));
								$this->session->userdata('is_connected', 1);
							}
							else
							{
								//Notification d'erreur
								$this->session->set_userdata('notif_err','<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Erreur...</strong> Bonjour '.$user_detected->name .' '.$user_detected->vorname.', votre mot de passe est incorrect... Veuillez réessayer !</div>');
								$this->session->set_userdata('notif_ok','');
							}
						}
						else
						{
							//Notification d'erreur
							$this->session->set_userdata('notif_err','<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Erreur...</strong> Aucun utilisateur a été trouvé... Veuillez réessayer !</div>');
							$this->session->set_userdata('notif_ok','');
						}
				}
				
				//suppression de l'image de connexion et de l'image formaté
				unlink(Upload::$upload_tmp_directory . '/' . $co_up->files_uploaded[0][0]);
				unlink(Upload::$upload_tmp_directory . '/R' . $co_up->files_uploaded[0][0]);
				
				if($password_ok)
					redirect('flux','refresh');
			}
		}
		
		//on affiche le formulaire
		$this->login();
	}
	
	
	/**
	 * Page d'inscription d'un nouvel user
	 */
	public function login()
	{
			//On change la vue du menu
			parent::setMenuView('menu/login_menu');
		
			parent::loadHeader();
			
			$this->load->view('notification_zone');
			$data['ruser'] = User::getRandomUsers(4);
			$this->load->view('home/login', $data);
			
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
