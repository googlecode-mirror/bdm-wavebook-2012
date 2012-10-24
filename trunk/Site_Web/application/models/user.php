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
			$query = $CI->db->query($sql,array($id));
			$row = $query->row();
			$this->id = $row->id_user;

		return $query;
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
