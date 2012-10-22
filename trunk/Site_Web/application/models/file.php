<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 	Modèle pour la table File_user (fichiers uploadé par un utilisateur)
*
*	CREATE TABLE IF NOT EXISTS `user_file` (
*	  `id_file` int(11) NOT NULL AUTO_INCREMENT,
*	  `id_user` int(11) NOT NULL,
*	  `type_file` enum('video','image','music','doc') NOT NULL,
*	  `desc_file` varchar(300) NOT NULL,
*	  `keywords_file` varchar(200) NOT NULL,
*	  `date_file` datetime NOT NULL,
*	  `url_file` varchar(200) NOT NULL,
*	  `size_file` int(11) NOT NULL,
*	  PRIMARY KEY (`id_file`),
*	  UNIQUE KEY `url_file` (`url_file`),
*	  KEY `fk_user_id_file` (`id_user`)
*	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
**/


class File extends CI_Model
{
	/*
	* Attributs statiques de la classe File_user
	*/
	public static $table = 'user_file';
	public static $file_directory = 'files';
	public static $file_per_page = 10;
	
	/**
	* Attribut d'une instance File_user
	*/
	public $id;
	public $id_user;
	public $desc;
	public $keywords;
	public $type;
	public $url;
	public $date;
	public $size;

	/**
	* Fonction permettant la récuperation des avatars d'un utilisateur (dernier dans la liste = avatar courant)
	* @param identifiant de utilisateur
	*/
	public static function getFilesByPage($from = 0, $to = File::$file_per_page)
	{	
		$list_files = array();
		$sql = 'SELECT * FROM '.File::$table.' ORDER BY date_file DESC LIMIT ?,?';
				
		$CI =& get_instance();	
		$query = $CI->db->query($sql,array($from, $to));
				
			foreach ($query->result() as $row)
			{
				$file = new File();

				$file->id = $row->id_file;
				$file->id_user = $row->id_user;
				$file->url = $row->url_file;
				$file->desc = $row->desc_file;
				$file->keywords = $row->keywords_file;
				$file->type = $row->type_file;
				$file->size = $row->size_file;
				$file->date = $row->date_file;
				
				$list_files[] = $file;
			}

		$query->free_result();
		
		return $list_files;
	}

	/**
	* Fonction permettant de retourner le lien du fichier
	*/
	public function getLink()
	{
		return User::$user_directory . '/' . $this->id_user . '/' . Avatar::$file_directory . '/' . $this->url;
	}

	/**
	* Fonction permettant de retourner le code HTML associe pour le visionnage
	*/
	public function getHTML()
	{
		//To be continued...
	}

	/**
	* Fonction permettant de créer un nouvel fichier dans la bdd
	*/
	public function save()
	{
			
		$sql = 'INSERT INTO '.File::$table.' VALUES(NULL,?,?,?,?,NOW(),?,?)';
		$CI =& get_instance();
			
		$query = $CI->db->query($sql, array($this->id_user, $this->type, $this->desc, $this->keywords, $this->url,$this->size));

		return $query;
	}
	
	
	/**
	* Fonction permettant d'afficher les informations du fichier (mode debug)
	*/
	public function toString()
	{
		echo 'ID=' . $this->id . ' --- ';
		echo 'ID_USER=' . $this->id_user . ' --- ';
		echo 'URL=' . $this->url  . ' --- ';
		echo 'DATE=' . $this->date . ' --- ';
		echo 'SIZE=' . $this->size  . ' --- ';
		echo 'DESC=' . $this->desc . ' --- ';
		echo 'KEYWORDS=' . $this->keywords  . ' --- ';
		echo 'TYPE=' . $this->type . ' --- ';
		echo 'REAL_LINK =' . $this->getLink() . ' --- ';
		echo 'HTML=' . htmlspecialchars($this->getHTML()) . ' --- ' ;
	}
	
}

?>
