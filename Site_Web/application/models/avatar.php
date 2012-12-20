<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 	Modèle pour la table Avatar_user (image de profil d'un utilisateur)
*
*	CREATE TABLE IF NOT EXISTS `user_avatar` (
*	  `id_avatar` int(11) NOT NULL AUTO_INCREMENT,
*	  `id_user` int(11) NOT NULL,
*	  `url_avatar` varchar(300) NOT NULL,
*	  `date_avatar` datetime NOT NULL,
*	  PRIMARY KEY (`id_avatar`),
*	  UNIQUE KEY `url_avatar` (`url_avatar`),
*	  KEY `fk_user_id_avatar` (`id_user`)
*	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
**/


class Avatar extends CI_Model
{
	/*
	* Attributs statiques de la classe Avatar_user
	*/
	public static $table = 'user_avatar';
	
	/**
	* Attribut d'une instance Avatar_user
	*/
	public $id;
	public $id_user;
	public $url;
	public $date;
	
	/**
	* Fonction permettant la récuperation des avatars d'un utilisateur (dernier dans la liste = avatar courant)
	* @param identifiant de utilisateur
	*/
	public static function getAvatarsByUserId($id_user = '')
	{
		$list_avatars = null;
		
			if(User::isUserExist($id_user))
			{
				
				$list_avatars = array();
				$sql = 'SELECT * FROM '.Avatar::$table.' WHERE id_user = ? ORDER BY date_avatar DESC';
				
				$CI =& get_instance();	
				$query = $CI->db->query($sql,array($id_user));
				
				foreach ($query->result() as $row)
				{
					$avatar = new Avatar();
					$avatar->id = $row->id_avatar;
					$avatar->id_user = $id_user;
					$avatar->url = $row->url_avatar;
					$avatar->date = $row->date_avatar;
					$list_avatars[] = $avatar;
				}

				$query->free_result();
			}
			
		return $list_avatars;
	}
	
	/**
	* Fonction permettant la récuperation d'un avatar par son id
	* @param identifiant de utilisateur
	*/
	public static function getAvatarById($id = '')
	{
		$avatar = null;
		$sql = 'SELECT * FROM '.Avatar::$table.' WHERE id_avatar = ?';
				
		$CI =& get_instance();	
		$query = $CI->db->query($sql,array($id));
		$row = $query->row();
				
		if($query->num_rows() > 0)
		{
			$avatar = new Avatar();
			$avatar->id = $id;
			$avatar->id_user = $row->id_user;
			$avatar->url = $row->url_avatar;
			$avatar->date = $row->date_avatar;
		}

		$query->free_result();

		return $avatar;
	}

	/**
	* Fonction permettant de retourner le lien de l'avatar
	*/
	public function getLink()
	{
		return base_url() . Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_avatar_directory . '/' . $this->url;
	}

	/**
	* Fonction permettant de retourner le lien de la miniature de l'avatar
	*/
	public function getMiniatureLink()
	{
		return base_url() . Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_avatar_mini_directory . '/' . $this->url;
	}

	/**
	* Fonction permettant de créer un nouvel avatar dans la bdd
	*/
	public function save()
	{
			
			$sql = 'INSERT INTO '.Avatar::$table.' VALUES(NULL,?,?,NOW())';
			$CI =& get_instance();
			
			$query = $CI->db->query($sql, array($this->id_user, $this->url));

			return $query;
	}
	
	/**
	* Fonction permettant de supprimer un avatar
	*/
	public function delete()
	{
			//suppression dans la base de données
			$sql = 'DELETE FROM '.Avatar::$table.' WHERE id_avatar = ?';
			$CI =& get_instance();
			$query = $CI->db->query($sql, array($this->id));
			
			//suppression sur le disque
			unlink(Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_avatar_directory . '/' . $this->url); // base
			unlink(Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_avatar_reco_directory . '/R' . $this->url); // refactorise
			unlink(Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_avatar_mini_directory . '/' . $this->url); // miniature
			
			return $query;
	}
	
	
	/**
	* Fonction permettant d'afficher les informations de l'avatar (mode debug)
	*/
	public function toString()
	{
		echo 'ID=' . $this->id . ' --- ';
		echo 'ID_USER=' . $this->id_user . ' --- ';
		echo 'URL=' . $this->url  . ' --- ';
		echo 'DATE=' . $this->date . ' --- ';
		echo 'REAL_LINK =' . $this->getLink() . ' --- ';
		echo 'MINI_LINK=' . $this->getMiniatureLink() . ' --- ' ;
	}
	
}

?>
