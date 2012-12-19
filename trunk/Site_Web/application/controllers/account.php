<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MemberController
{
	/**
	* Constructeur
	*/
	public function __construct()
	{
		parent::__construct();
		
		//On change le titre de la page
		parent::setPageName('Modifier son avatar');
		
		//On change la vue du menu
		parent::setMenuView('menu/account_menu');
	}

	public function logout()
	{
		// Suppression de la session
		$this->session->unset_userdata('is_connected');
		$this->session->unset_userdata('user_obj');
		
		// Notification de deconnexion
		$this->session->set_userdata('notif_ok','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Vous avez été déconnecté !</div>');

		
		redirect('', 'refresh');
	}
	
	public function upload_new_avatar_with_cam()
	{
		//Upload de la nouvelle image de profil
		$user_id = unserialize($this->session->userdata('user_obj'))->id;
		$upload = new Upload();
		$res = $upload->upload_avatar_capture($user_id, array($this->input->post('url_capture')));

		//Enregistrement dans la BDD
		if($res)
		{
			$new_avatar = new Avatar();
			$new_avatar->url = $upload->files_uploaded[0][0];
			$new_avatar->id_user = $user_id;
			$new_avatar->save();
			
			$this->session->set_userdata('notif_err','');
			$this->session->set_userdata('notif_ok','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Bravo!</strong> Votre image de profil a bien été changée.</div>');
		}

		redirect('account/change_img_profile', 'refresh');
	}

	public function upload_new_avatar()
	{
		//Upload de la nouvelle image de profil
		$user_id = unserialize($this->session->userdata('user_obj'))->id;
		$upload = new Upload();
		$res = $upload->upload_avatar($user_id, array('userfile'));

		//Enregistrement dans la BDD
		if($res)
		{
			$new_avatar = new Avatar();
			$new_avatar->url = $upload->files_uploaded[0][0];
			$new_avatar->id_user = $user_id;
			$new_avatar->save();
		}

		redirect('account/change_img_profile', 'refresh');
	}

	public function change_img_profile()
	{
		parent::loadHeader();

		$data = array();
		$data['list_avatars'] = Avatar::getAvatarsByUserId(unserialize($this->session->userdata('user_obj'))->id);
		
		$this->load->view('notification_zone');
		$this->load->view('account/change_avatar',$data);
		parent::loadFooter();
	}

	public function settings()
	{
		parent::loadHeader();

		$user = unserialize($this->session->userdata('user_obj'));
		$data = array();
		$data['user'] = $user;

		$this->load->view('notification_zone');
		$this->load->view('account/change_settings', $data);

		parent::loadFooter();
	}

	public function settings_validation()
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
			
		if ($this->form_validation->run() == FALSE) // echec
		{
			//on affiche le formulaire
			$this->settings();
		}
		else // reussite
		{
			//creation de l'utilisateur
			$user = unserialize($this->session->userdata('user_obj'));
			$user->name = $this->input->post('name');
			$user->vorname = $this->input->post('vorname');
			$user->password = strtolower($this->input->post('password'));
			$user->email = $this->input->post('email');
			if($this->input->post('sexe') == "Femme") $user->sex = 0;
			else $user->sex = 1;
			
			//sauvegarde de l'utilisateur
			$user->update();
			$this->session->set_userdata('user_obj',  serialize($user));
			
			//notification
			$this->session->set_userdata('notif_ok','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Bravo!</strong> Vos informations personnelles ont été modifiée.</div>');
			
			//redirection sur l'accueil
			redirect('account/settings','refresh');
		}
	}
}
