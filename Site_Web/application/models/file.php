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
*	  `url_file` varchar(200) NOT NULL
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

	/**
	* Fonction permettant la récuperation des avatars d'un utilisateur (dernier dans la liste = avatar courant)
	* @param identifiant de utilisateur
	*/
	public static function getFilesByPage($from = 0)
	{	
		$list_files = array();
		$sql = 'SELECT * FROM '.File::$table.' ORDER BY date_file DESC LIMIT ?,?';
				
		$CI =& get_instance();	
		$query = $CI->db->query($sql,array($from, File::$file_per_page));
				
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
	* Fonction permettant de retourner le lien du fichier
	*/
	public function getLink()
	{
		return base_url() . Upload::$upload_directory . '/' . $this->id_user . '/' . Upload::$upload_file_directory . '/' . $this->url;
	}

	/**
	* Fonction permettant de retourner le code HTML associe pour le visionnage
	*/
	public function getHTML()
	{
		$html = '<a href="'.$this->getLink().'"><img src="'.img('document-icon.png').'" alt="Télécharger le document" title="Télécharger le document" /> Télécharger le document</a>';
		
		if($this->type == 'image')
		{
			$html = '<img src="'.$this->getLink().'" class="post" alt="Lien mort" title="Lien mort" />';
		}
		else if($this->type == 'video')
		{
			$html = '<video height="250" controls>
					<source src="'.$this->getLink().'" />
					<div class="alert alert-warning">Ce format n\'est pas géré par votre navigateur !</div>
				</video>';
		}
		else if($this->type == 'music')
		{
			$html = '<audio controls>
					<source src="'.$this->getLink().'" />
					<div class="alert alert-warning">Ce format n\'est pas géré par votre navigateur !</div>
				</audio>';
		}

		return $html;
	}

	/**
	* Fonction permettant de créer un nouvel fichier dans la bdd
	*/
	public function save()
	{
			
		$sql = 'INSERT INTO '.File::$table.' VALUES(NULL,?,?,?,?,NOW(),?)';
		$CI =& get_instance();
			
		$query = $CI->db->query($sql, array($this->id_user, $this->type, $this->desc, $this->keywords, $this->url));

		return $query;
	}


	/**
	* Fonction permettant de rechercher des fichiers par leurs tags et/ou leurs descriptions
	*/
	public function search($keywordToSearch, $from = 0)
	{
		$list_files = array();
		
		// Création de la requete SQL dynamiquement (decoupage de la chaine par espace)
		$list_keywords = array();
		$first = true;
		$sql = 'SELECT * FROM '.File::$table.' WHERE';
		foreach(explode(" ", $keywordToSearch) as $keyword)
		{
			$list_keywords[] = "%$keyword%";
			$list_keywords[] = "%$keyword%";
			
			if(!$first)
			{
				$sql .= ' OR';
			}
			else
			{
				$first = false;
			}
			
			$sql .= ' (desc_file LIKE ? OR keywords_file LIKE ?)';
		}
		
		$sql .= ' ORDER BY date_file DESC LIMIT ?,?';
		$list_keywords[] = $from;
		$list_keywords[] = File::$file_per_page;
		
		// Execution de la requete SQL
		$CI =& get_instance();	
		$query = $CI->db->query($sql, $list_keywords);
				
		// Extraction des fichiers
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
	* Fonction permettant d'afficher les informations du fichier (mode debug)
	*/
	public function toString()
	{
		echo 'ID=' . $this->id . ' --- ';
		echo 'ID_USER=' . $this->id_user . ' --- ';
		echo 'URL=' . $this->url  . ' --- ';
		echo 'DATE=' . $this->date . ' --- ';
		echo 'DESC=' . $this->desc . ' --- ';
		echo 'KEYWORDS=' . $this->keywords  . ' --- ';
		echo 'TYPE=' . $this->type . ' --- ';
		echo 'REAL_LINK =' . $this->getLink() . ' --- ';
		echo 'HTML=' . htmlspecialchars($this->getHTML()) . ' --- ' ;
	}
	
}

?>
