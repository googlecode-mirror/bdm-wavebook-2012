<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 	Modèle pour la table Users
*
*	CREATE TABLE IF NOT EXISTS `users` (
*	  `id_user` int(11) NOT NULL AUTO_INCREMENT,
*	  `name_user` varchar(20) NOT NULL,
* 	 `vorname_user` varchar(20) NOT NULL,
* 	 `email_user` varchar(150) NOT NULL,
* 	 `sex_user` tinyint(1) NOT NULL,
* 	 `password_user` varchar(20) NOT NULL,
* 	 `date_user` date NOT NULL,
* 	 PRIMARY KEY (`id_user`)
*	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
**/


class User extends CI_Model
{
	/*
	* Attributs statiques de la classe User
	*/
	public static $table = 'users';
	public static $nb_file_user_matched = 20;
	
	/**
	* Attribut d'une instance User
	*/
	public $id;
	public $name;
	public $vorname;
	public $email;
	public $sex;
	public $password;
	public $date;
	
	
	/**
	* Fonction permettant la recherche d'un utilisateur (verification d'existance incluse)
	* @param identifiant de utilisateur
	*/
	public static function getUserById($id = '')
	{
		$user = null;
		
			if(User::isUserExist($id))
			{
				$user = new User();
				
				$sql = 'SELECT * FROM '.User::$table.' WHERE id_user = ?';
				
				$CI =& get_instance();	
				$query = $CI->db->query($sql,array($id));
				$row = $query->row();
				
				$user->id = $id;
				$user->name = $row->name_user;
				$user->vorname = $row->vorname_user;
				$user->email = $row->email_user;
				$user->sex = $row->sex_user;
				$user->date = $row->date_user;
				$user->password = $row->password_user;

				$query->free_result();
			}
			
		return $user;
	}
	
	/**
	* Fonction permettant de renvoyer des utilisateurs aléatoirement
	* @param nb d'utilisateurs
	*/
	public static function getRandomUsers($limit = 5)
	{
		$list_users = array();
		
		$sql = 'SELECT * FROM '.User::$table.' ORDER BY RAND() LIMIT ?';	
		$CI =& get_instance();	
		$query = $CI->db->query($sql,array($limit));
		
		foreach ($query->result() as $row)
		{
			$user = new User();
			
			$user->id = $row->id_user;
			$user->name = $row->name_user;
			$user->vorname = $row->vorname_user;
			$user->email = $row->email_user;
			$user->sex = $row->sex_user;
			$user->date = $row->date_user;
			$user->password = $row->password_user;
			
			$list_users[] = $user;
		}
		
		return $list_users;
	}
	
	/**
	* Fonction determinant si l'utilisateur N existe
	* @param identifiant de l'article à trouver
	*/
	public static function isUserExist($id = '')
	{
		$res = false;
		if(is_numeric($id)) 
		{
			$sql = 'SELECT * FROM '.User::$table.' WHERE id_user = ?';
			
			$CI =& get_instance();
			$query = $CI->db->query($sql,array($id));
			if($query->num_rows() > 0)
			{
				$res = true;
			}
			
			$query->free_result();
		}
		
		return $res;
	}

	/**
	* Fonction permettant de retourner les X derniers partages de l'utilisateur
	*/
	public function getUserFiles()
	{
		$list_files = array();
		$sql = 'SELECT * FROM '.File::$table.' WHERE id_user = ? ORDER BY date_file DESC LIMIT 0,?';
				
		$CI =& get_instance();	
		$query = $CI->db->query($sql,array($this->id, User::$nb_file_user_matched));
				
			foreach ($query->result() as $row)
			{
				$file = new File();

				$file->id = $row->id_file;
				$file->id_user = $row->id_user;
				$file->url = $row->url_file;
				$file->desc = $row->desc_file;
				$file->keywords = $row->keywords_file;
				$file->type = $row->type_file;
				$file->date = $row->date_file;
				
				$list_files[] = $file;
			}

		$query->free_result();
		
		return $list_files;
	}

	/**

	* Fonction permettant de retourner les X derniers partages de l'utilisateur
	*/
	public function countUserFiles()
	{
		$sql = 'SELECT * FROM '.File::$table.' WHERE id_user = ?';
		$CI =& get_instance();	
		$query = $CI->db->query($sql,array($this->id));

		return $query->num_rows();
		
	}
	
	/**
	* Fonction comptant le nombre d'utilisateurs totals dans la base
	*/
	public static function countUser()
	{
			$sql = 'SELECT * FROM '.User::$table;
			$CI =& get_instance();
			$query = $CI->db->query($sql);
			
			return $query->num_rows();
	}
	
	/**
	* Fonction permettant de créer un nouvel utilisateur dans la bdd
	*/
	public function save()
	{
			
			$sql = 'INSERT INTO '.User::$table.' VALUES(NULL,?,?,?,?,?,NOW())';
			$CI =& get_instance();
			
			$query = $CI->db->query($sql, array($this->name, $this->vorname, $this->email, $this->sex, $this->password));

			//on récupere l'identifiant de l'utilisateur (autoincrement)
			$sql = 'SELECT id_user FROM '.User::$table.' WHERE vorname_user = ? AND email_user = ? AND name_user = ?';
			$query = $CI->db->query($sql,array($this->vorname, $this->email,$this->name));
			$row = $query->row();
			$this->id = $row->id_user;
			
			//creation de son espace
			$this->createUserSpace();

		return $query;
	}
	
	/**
	 * Fonction permettant de créer l'espace de travail d'un utilisateur
	 */
	private function createUserSpace()
	{
		 mkdir($this->getUserDir(), 0777);
		 exec('(cd '.$this->getUserDir() . '; echo "<h1>Access Denied !</h1>" > index.php)');
		 mkdir($this->getUserFileDir(), 0777);
		 exec('(cd '.$this->getUserFileDir() . '; echo "<h1>Access Denied !</h1>" > index.php)');
		 mkdir($this->getUserAvatarDir(), 0777);
		 exec('(cd '.$this->getUserAvatarDir() . '; echo "<h1>Access Denied !</h1>" > index.php)');
		 mkdir($this->getUserAvatarRecoDir(), 0777);
		 exec('(cd '.$this->getUserAvatarRecoDir() . '; echo "<h1>Access Denied !</h1>" > index.php)');
		 mkdir($this->getUserAvatarMiniDir(), 0777);
		 exec('(cd '.$this->getUserAvatarMiniDir() . '; echo "<h1>Access Denied !</h1>" > index.php)');
	}
	
	/**
	 * Fonction permettant de supprimer l'espace de travail d'un utilisateur
	 */
	private function removeUserSpace()
	{
		$this->deleteDirectory($this->getUserDir());
	}
	
	//supprimer un repertoire recursivement
	private function deleteDirectory($dirname)
	{
		foreach (scandir($dirname) as $item) 
		{
			$url = $dirname.'/'.$item;
			
			if ($item == '.' || $item == '..') continue; // on ne supprime pas !
			else if(is_dir($url)) $this->deleteDirectory($url); // si repertoire, on lance un appel recursif
			else unlink($url); // on supprime le fichier
		}
		
		rmdir($dirname);
	}
	
	
	/**
	* Fonction permettant de mettre à jour un utilisateur dans la bdd
	*/
	public function update()
	{
			$sql = 'UPDATE '.User::$table.' SET name_user = ?, vorname_user = ?, email_user = ?, sex_user = ?, password_user = ? WHERE id_user = ?';

			$CI =& get_instance();
			$query = $CI->db->query($sql, array($this->name, $this->vorname, $this->email, $this->sex, $this->password, $this->id));
		
			return $query;
	}
	
	/**
	* Fonction permettant de supprimer un utilisateur dans la bdd
	*/
	public function delete()
	{
			//suppression de l'utilisateur
			$sql = 'DELETE FROM '.User::$table.' WHERE id_user = ?';

			$CI =& get_instance();
			$query = $CI->db->query($sql, array($this->id));
			
			//suppression de son espace
			$this->removeUserSpace();
		
			return $query;
	}
	
	/**
	* Fonction permettant de retourner l'url complete du repertoire global de l'utilisateur
	*/
	public function getUserDir()
	{
		return Upload::$upload_directory . '/' . $this->id;
	}
	
	/**
	* Fonction permettant de retourner l'url complete du repertoire de fichier de l'utilisateur
	*/
	public function getUserFileDir()
	{
		return $this->getUserDir() . '/' . Upload::$upload_file_directory ;
	}
	
	/**
	* Fonction permettant de retourner l'url complete du repertoire des avatars de l'utilisateur
	*/
	public function getUserAvatarDir()
	{
		return $this->getUserDir() . '/' . Upload::$upload_avatar_directory;
	}
	
	/**
	* Fonction permettant de retourner l'url complete du repertoire des miniatures des avatars de l'utilisateur
	*/
	public function getUserAvatarMiniDir()
	{
		return $this->getUserDir() . '/' . Upload::$upload_avatar_mini_directory;
	}
	
	/**
	* Fonction permettant de retourner l'url complete du repertoire des images refactorées (pour reconnaissance) des avatars de l'utilisateur
	*/
	public function getUserAvatarRecoDir()
	{
		return $this->getUserDir() . '/' . Upload::$upload_avatar_reco_directory;
	}
	
	
	/**
	* Fonction permettant d'afficher les informations de l'utilisateur (mode debug)
	*/
	public function toString()
	{
		echo 'ID=' . $this->id . ' --- ';
		echo 'NOM=' . $this->name . ' --- ';
		echo 'PRENOM=' . $this->vorname  . ' --- ';
		echo 'EMAIL=' . $this->email . ' --- ';
		echo 'SEXE =' . $this->sexe . ' --- ';
		echo 'DATE=' . $this->date . ' --- ' ;
		echo 'PASSWORD=' . $this->password . ' --- ';

	}
	
}

?>
