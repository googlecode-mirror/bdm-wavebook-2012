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
	public static $upload_tmp_directory = '../Base_de_donnees/tmp';
	public static $upload_file_directory = 'files';
	public static $upload_avatar_directory = 'profile';
	public static $upload_avatar_mini_directory = 'profile/mini';
	public static $upload_avatar_reco_directory = 'profile/reco';

	public static $image_file_extension = 'jpg|jpeg|bmp|png';
	public static $video_file_extension = 'mp4|ogv|webm';
	public static $music_file_extension = 'mp3|wma|ogg|wav';
	public static $document_file_extension = 'doc|docx|pdf|txt|zip|rar|tar|odt';

	private static $file_override = FALSE; 
	private static $file_remove_space = TRUE;
	private static $max_filesize = 10000;
	private static $max_imgwidth = 3000;
	private static $max_imgheight = 3000;
	
	private static $max_multiple_file = 5;


	/**
	* Attributs
	**/
	public $id_user;
	public $files_available;
	public $files_uploaded;

	
	/**
	* Constructeur
	*/
	public function __construct()
	{
		parent::__construct();
		
		$this->id_user = -1;
		$this->files_available = array();
		$this->files_uploaded = array();
	}
	
	/**
	* Demande d'un upload d'une/des image(s) de profil (utilisée pour la reconnaissance)
	*/
	public function upload_avatar($id_user, $user_files = array())
	{
		$this->id_user = $id_user;
		$this->files_available = $user_files;
		
		$config = $this->configure_avatar_upload();

		$res = $this->launch_upload($config);

		if($res)
		{
			//creation des images refactorisés
			for($i = 0; $i < count($this->files_uploaded); $i++)
			{
				//echo '(cd ../Reconnaissance_Faciale/ ; make run ARG=2 IMG='.Upload::$upload_directory . '/' .$this->id_user . '/'. Upload::$upload_avatar_directory . '/' . $this->files_uploaded[$i][0].' ID='.$this->id_user.')';
				exec('(export LD_LIBRARY_PATH="OpenCV-2.4.2/release/lib/" ; cd ../Reconnaissance_Faciale/ ; bin/main 2 "'.Upload::$upload_directory . '/' .$this->id_user . '/'. Upload::$upload_avatar_directory . '/' . $this->files_uploaded[$i][0].' '.$this->id_user.'")', $output, $return);
				
				//echo $return;
				//echo print_r($output) . 'lol';
				
				if($return == 0) //pas de visage
				{
					unlink(Upload::$upload_directory . '/' .$this->id_user . '/'. Upload::$upload_avatar_directory . '/' . $this->files_uploaded[$i][0]); //suppression de l'image d'origine
					unset($this->files_uploaded[$i]);
					$this->files_uploaded = array_values($this->files_uploaded);
					$i--;
				}
			
			}

			//creation des miniatures
			for($i = 0; $i < count($this->files_uploaded); $i++)
				$this->create_miniature($this->files_uploaded[$i][0], false);
				
			//verification de reussite
			if(count($this->files_uploaded) == 0)
			{
				$res = false;
				$this->session->set_userdata('notif_err','<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Attention !</strong> Aucun visage n\'a été détecté sur l\'image !</div>');
				$this->session->set_userdata('notif_ok','');
			}
		}

		return $res;
	}
	
	/**
	* Demande d'un upload d'une/des image(s) de profil prise avec une webcam (utilisée pour la reconnaissance)
	*/
	public function upload_avatar_capture($id_user, $user_files = array())
	{
		$res = false;
		$this->id_user = $id_user;
		$this->files_available = $user_files;
		
		// 1 . deplacement des images dans le repertoires de l'user
		for($i = 0; $i < count($this->files_available); $i++)
		{
				$res = rename(Upload::$upload_tmp_directory . '/' . $this->files_available[$i], Upload::$upload_directory . '/' .$this->id_user . '/'. Upload::$upload_avatar_directory . '/' . $this->files_available[$i]);
				if($res)
				{
					$new_avatar = array();
					$new_avatar[] = $this->files_available[$i];
					array_push($this->files_uploaded, $new_avatar);
				}
		}
		
		// si il y a au moins une image
		if(count($this->files_uploaded) > 0)
		{
			//2. Creation des images refactorisés (verification de visage)
			for($i = 0; $i < count($this->files_uploaded); $i++)
			{
				exec('(export LD_LIBRARY_PATH="OpenCV-2.4.2/release/lib/" ; cd ../Reconnaissance_Faciale/ ; bin/main 2 "'.Upload::$upload_directory . '/' .$this->id_user . '/'. Upload::$upload_avatar_directory . '/' . $this->files_uploaded[$i][0].' '.$this->id_user.'")', $output, $return);
				
				if($return == 0) //pas de visage
				{
					unlink(Upload::$upload_directory . '/' .$this->id_user . '/'. Upload::$upload_avatar_directory . '/' . $this->files_uploaded[$i][0]); //suppression de l'image d'origine
					unset($this->files_uploaded[$i]);
					$this->files_uploaded = array_values($this->files_uploaded);
					$i--;
				}
			
			}

			//3. Creation des miniatures
			for($i = 0; $i < count($this->files_uploaded); $i++)
				$this->create_miniature($this->files_uploaded[$i][0], true);
				
			//verification de reussite
			$res = true;
			if(count($this->files_uploaded) == 0)
			{
				$res = false;
				$this->session->set_userdata('notif_err','<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Attention !</strong> Aucun visage n\'a été détecté sur l\'image !</div>');
				$this->session->set_userdata('notif_ok','');
			}
		}
		else
		{
			$res = false;
			$this->session->set_userdata('notif_err','<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Attention !</strong> Aucune image uploadé !</div>');
			$this->session->set_userdata('notif_ok','');
		}

		return $res;
	}

	

	/**
	* Demande d'un upload d'images ou/et de sons dans un fichier temporaire (utilisée lors de la connexion)
	*/
	public function upload_tmp_file($user_files = array())
	{
		$this->files_available = $user_files;
		
		$config = $this->configure_tmp_upload();
		$res = $this->launch_upload($config);
		
		if($res)
		{
			//creation des images refactorisés
			for($i = 0; $i < count($this->files_uploaded); $i++)
			{
				//echo '(export LD_LIBRARY_PATH="OpenCV-2.4.2/release/lib/" ; cd ../Reconnaissance_Faciale/ ; bin/main 2 '.Upload::$upload_tmp_directory . '/' . $this->files_uploaded[$i][0].')';
				exec('(export LD_LIBRARY_PATH="OpenCV-2.4.2/release/lib/" ; cd ../Reconnaissance_Faciale/ ; bin/main 2 "'.Upload::$upload_tmp_directory . '/' . $this->files_uploaded[$i][0].'")', $output, $return);

				//echo $return;
				//print_r($output);
				if($return == 0) //pas de visage
				{
					unlink(Upload::$upload_tmp_directory . '/' . $this->files_uploaded[$i][0]); //suppression de l'image d'origine
					unset($this->files_uploaded[$i]);
					$this->files_uploaded = array_values($this->files_uploaded);
					$i--;
				}
			}	
				
			//verification de reussite
			if(count($this->files_uploaded) == 0)
			{
				$res = false;
				$this->session->set_userdata('notif_err','<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Attention !</strong> Aucun visage n\'a été détecté sur l\'image !</div>');
				$this->session->set_userdata('notif_ok','');
			}
				
		}
	
		return $res;
	}

	/**
	* Demande d'un upload d'un fichier de partage (non-utilisée pour la reconnaissance)
	*/
	public function upload_file($id_user, $user_files = array())
	{
		$this->id_user = $id_user;
		$this->files_available = $user_files;

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
		$config['notif_ok'] = "Votre image de profil a bien été changée !";

		return $config;
	}

	/**
	* Configuration d'un upload d'un fichier temporel
	*/
	private function configure_tmp_upload()
	{
		//configuration de l'upload
		$config['upload_path'] =  Upload::$upload_tmp_directory . '/';
		$config['allowed_types'] = Upload::$image_file_extension . '|' . Upload::$music_file_extension;
		$config['max_size']	= Upload::$max_filesize;
		$config['max_width'] = Upload::$max_imgwidth;
		$config['max_height'] = Upload::$max_imgheight;
		$config['overwrite'] = Upload::$file_override;
		$config['remove_spaces'] = Upload::$file_remove_space;
		$config['notif_ok'] = "Votre fichier a été envoyé sur notre serveur, vérification en cours...";
		
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
		$config['notif_ok'] = "Votre fichier a bien été partagé !";
		
		return $config;
	}
	
	/**
	* Lancement de l'upload (gere le multi-upload)
	*/
	private function launch_upload($config)
	{
		$res = false;
		
		//appel de la library d'upload
		$CI =& get_instance();	
		$CI->load->library('upload', $config);
		
		//Si pas de fichier spécifiés à l'entrée
		//MODE PAR DEFAUT = upload de tous les fichiers file_x
		if(count($this->files_available) == 0)
		{
			for ($i = 1; $i <= count($_FILES) && $i <= Upload::$max_multiple_file; $i++ )
			{
				if(isset($_FILES['file_'.$i]))
				{
					if(!empty($_FILES['file_'.$i]['name']))
					{
						array_push($this->files_available,'file_'.$i);
					}
				}
			}
		}
		
		// DEBUG: 
		//print_r($this->files_available);
		// Lancement de l'upload (fichier après fichier)
		for($i = 0 ; $i < count($this->files_available); $i++)
		{
			if(!$CI->upload->do_upload($this->files_available[$i])) //on teste si l'upload fonctionne
			{
				//erreur !
				// On enregistre l'erreur dans une variable de session
				$this->session->set_userdata('notif_err', $this->upload->display_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'));
			}
			else
			{
				
			// On retient le nom et le type du fichier (pour insertion à la bdd)
			$data = $this->upload->data($this->files_available[$i]);
			$new_file = array();
			$new_file[] = $data['file_name'];
			$new_file[] = $this->getRealType($data['file_ext']);
			
			// Ajout au tableau des fichiers uploadés
			array_push($this->files_uploaded, $new_file);
			}
		}
		
		// Vérification de réussite (au moins un fichier uploadé)
		if(count($this->files_uploaded) > 0)
		{
			$res = true;
			$this->session->set_userdata('notif_err','');
			$this->session->set_userdata('notif_ok','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Bravo!</strong> '.$config['notif_ok'].'</div>');
		}
		else
		{
			if(count($this->files_available) == 0)
			{
				$this->session->set_userdata('notif_err','<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Erreur!</strong> Veuillez choisir au moins un fichier !</div>');
				$this->session->set_userdata('notif_ok','');
			}
		}
	
		return $res;
	}

	/**
	* Permet de determiner si le fichier est un document, image, video ou musique (A FINIR)
	*/
	private function getRealType($type)
	{
		$type = strtolower(substr($type, 1));
		if(preg_match('/'.Upload::$image_file_extension.'/', $type) == 1)
		{
			$rtype = "image";
		}
		else if(preg_match('/'.Upload::$music_file_extension.'/', $type) == 1)
		{
			$rtype = "music";
		}
		else if(preg_match('/'.Upload::$video_file_extension.'/', $type))
		{
			$rtype = "video";
		}
		else
		{
			$rtype = "doc";
		}
		
		return $rtype;
	}

	/**
	* Méthode permettant de créer une miniature de l'image de profil (150x150px)
	*/
	private function create_miniature($filename, $is_capture)
	{
		$CI =& get_instance();
		if(!$is_capture)
			$data = $CI->upload->data();
		$CI->load->library('image_lib');

		// Chemins
		$real_path = Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_avatar_directory . '/' . $filename;
		$mini_path = Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_avatar_mini_directory . '/' . $filename;


		// Configuration du redimentionnement de la copie
		$config['image_library'] = 'gd2';
		$config['source_image']	= $real_path;
		$config['new_image'] = $mini_path;
		$config['maintain_ratio'] = TRUE;
		$config['width']	 = 150;
		$config['height']	= 150;
		
		if(!$is_capture)
			$config['master_dim'] = ($data['image_height'] > $data['image_width']) ? 'width' : 'height';
		else
			$config['master_dim'] = 'height';
			
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
