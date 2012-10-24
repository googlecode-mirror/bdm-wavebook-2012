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

	public function upload_new_avatar()
	{
		//Upload de la nouvelle image de profil
		$user_id = unserialize($this->session->userdata('user_obj'))->id;
		$upload = new Upload();
		$res = $upload->upload_avatar($user_id);

		//Enregistrement dans la BDD
		if($res)
		{
			$new_avatar = new Avatar();
			$new_avatar->url = $upload->filename;
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
}
