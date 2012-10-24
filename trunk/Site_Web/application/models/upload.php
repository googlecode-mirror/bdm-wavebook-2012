<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 	Modele permettant de gérer tous les uploads des utilisateurs
*	- image de profil
*	- image de connexion (placée dans un repertoire temporaire, le temps de la reconnaissance)
*	- fichier de partage
**/

class Upload extends CI_Model
{
	/**
	* Attributs statiques
	*/

	public static $upload_directory = '../Base_de_donnees/upload';
	public static $upload_file_directory = 'files';
	public static $upload_tmp_file_directory = 'tmp';
	public static $upload_avatar_directory = 'profile';
	public static $upload_avatar_mini_directory = 'profile/mini';

	public static $image_file_extension = 'jpg|jpeg|bmp|png';
	public static $video_file_extension = 'mp4|ogv|webm';
	public static $music_file_extension = 'mp3|wma|ogg|wav';
	public static $document_file_extension = 'doc|docx|pdf|txt|zip|rar|tar|odt';

	private static $file_override = FALSE; 
	private static $file_remove_space = TRUE;
	private static $max_filesize = 10000;
	private static $max_imgwidth = 3000;
	private static $max_imgheight = 3000;


	/**
	* Attributs
	**/
	public $id_user;
	public $filename;
	public $filetype;

	
	/**
	* Constructeur
	*/
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	* Demande d'un upload d'une image de profil (utilisée pour la reconnaissance)
	*/
	public function upload_avatar($id_user)
	{
		$this->id_user = $id_user;
		$config = $this->configure_avatar_upload();

		$res = $this->launch_upload($config);

		if($res)
		{
			$this->create_miniature();
		}

		return $res;
	}

	/**
	* Demande d'un upload d'une image ou d'un son dans un fichier temporaire (utilisée lors de la connexion)
	*/
	public function upload_tmp_file($id_user)
	{
		$this->id_user = $id_user;
		$config = $this->configure_tmp_upload();

		return $this->launch_upload($config);
	}

	/**
	* Demande d'un upload d'un fichier de partage (non-utilisée pour la reconnaissance)
	*/
	public function upload_file($id_user)
	{
		$this->id_user = $id_user;
		$config = $this->configure_file_upload();

		return $this->launch_upload($config);
	}
	
	/**
	* Configuration d'un upload d'une image de profil
	*/
	private function configure_avatar_upload()
	{
		//configuration de l'upload
		$config['upload_path'] = Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_avatar_directory . '/';
		$config['allowed_types'] = Upload::$image_file_extension;
		$config['max_size']	= Upload::$max_filesize;
		$config['max_width'] = Upload::$max_imgwidth;
		$config['max_height'] = Upload::$max_imgheight;
		$config['overwrite'] = Upload::$file_override;
		$config['remove_spaces'] = Upload::$file_remove_space;

		return $config;
	}

	/**
	* Configuration d'un upload d'un fichier temporel
	*/
	private function configure_tmp_upload()
	{
		//configuration de l'upload
		$config['upload_path'] = Upload::$upload_directory . '/' . Upload::$upload_tmp_file_directory . '/';
		$config['allowed_types'] = Upload::$image_file_extension . '|mp3';
		$config['max_size']	= Upload::$max_filesize;
		$config['max_width'] = Upload::$max_imgwidth;
		$config['max_height'] = Upload::$max_imgheight;
		$config['overwrite'] = Upload::$file_override;
		$config['remove_spaces'] = Upload::$file_remove_space;
		
		return $config;
	}
	
	/**
	* Configuration d'un upload d'un fichier de partage
	*/
	private function configure_file_upload()
	{
		//configuration de l'upload
		$config['upload_path'] = Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_file_directory . '/';
		$config['allowed_types'] = Upload::$image_file_extension . '|' . Upload::$music_file_extension . '|' . Upload::$video_file_extension . '|' . Upload::$document_file_extension;
		$config['max_size']	= Upload::$max_filesize;
		$config['max_width'] = Upload::$max_imgwidth;
		$config['max_height'] = Upload::$max_imgheight;
		$config['overwrite'] = Upload::$file_override;
		$config['remove_spaces'] = Upload::$file_remove_space;
	
		return $config;
	}
	
	/**
	* Lancement de l'upload
	*/
	private function launch_upload($config)
	{

		//appel de la library d'upload
		$CI =& get_instance();	
		$CI->load->library('upload', $config);

		if (!$CI->upload->do_upload()) //on teste si l'upload fonctionne
		{
			//erreur !
			// On enregistre l'erreur dans une variable de session
			$this->session->set_userdata('notif_err', $this->upload->display_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'));

			$res = false;

		}
		else
		{
			//ok !
			$data = $CI->upload->data();
			$this->filename = $data['file_name'];
			//$this->filetype = $this->getRealType($data['file_type']);

			// On enregistre la notif de réussite dans une variable de session
			$this->session->set_userdata('notif_ok','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Bravo!</strong> Votre image de profil a bien été changée !</div>');
			
			$res = true;
		}

		return $res;
	}

	/**
	* Permet de determiner si le fichier est un document, image, video ou musique (A FINIR)
	*/
	private function getRealType($type)
	{
		// A CODER
		return $type;
	}

	/**
	* Méthode permettant de créer une miniature de l'image de profil (150x150px)
	*/
	private function create_miniature()
	{
		$CI =& get_instance();	
		$data = $CI->upload->data();
		$CI->load->library('image_lib');

		// Chemins
		$real_path = Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_avatar_directory . '/' . $this->filename;
		$mini_path = Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_avatar_mini_directory . '/' . $this->filename;


		// Configuration du redimentionnement de la copie
		$config['image_library'] = 'gd2';
		$config['source_image']	= $real_path;
		$config['new_image'] = $mini_path;
		$config['maintain_ratio'] = TRUE;
		$config['width']	 = 150;
		$config['height']	= 150;
		$config['master_dim'] = ($data['image_height'] > $data['image_width']) ? 'width' : 'height';

		// Redimentionnement
		$CI->image_lib->initialize($config);
		$CI->image_lib->resize();

		// Configuration du recadrage
		$config['source_image']	= $mini_path;
		$config['maintain_ratio'] = FALSE;
		$config['x_axis'] = '0';
		$config['y_axis'] = '0';
		
		// Recadrage
		$CI->image_lib->clear();
		$CI->image_lib->initialize($config);
		$CI->image_lib->crop();


	}




}
