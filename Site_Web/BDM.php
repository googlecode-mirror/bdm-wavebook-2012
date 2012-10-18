<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>BDM - Upload d'un fichier multimédia</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>

	<body>
		<?php
		$ext_allow = array('jpg', 'jpeg', 'png', 'mp3'); //extensions autorisées
		$mimes_allow = array('image/jpeg', 'image/png', 'audio/mpeg'); //mimes-type autorisés

		// Reçu sans erreur
		if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK)
		{			
			// Recupérons l'extension
			$infosfichier = pathinfo($_FILES['file']['name']);
			$extensionfichier = strtolower($infosfichier['extension']);

			// Récupérons le mime-type
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mimefichier = finfo_file($finfo, $_FILES['file']['tmp_name']);								
			finfo_close($finfo);

			if (in_array($extensionfichier, $ext_allow) && in_array($mimefichier, $mimes_allow) )
			{
				// On peut valider le fichier et le stocker définitivement
				if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . basename($infosfichier['filename']).'_'.uniqid(mt_rand(),true).'.'.$infosfichier['extension']))
				{
					echo 'Fichier reçu et enregistré ! <a href="">Retour au formulaire</a>.';
				}
				else
				{
					echo 'Erreur lors de l\'enregistrement du fichier ! Merci de réessayer plus tard. <a href="">Retour au formulaire</a>.';
				}
			}
			else //l'ext n'est pas autorisée.
			{
				echo 'Ce type de fichier n\'est pas autorisé ! <a href="">Retour au formulaire</a>.';
			}	
		}
		else // sinon, on affiche le formulaire
		{
		
			// Fichier trop gros -> upload_max_filesize || max_file_size -> message d'erreur			
			if (isset($_FILES['file']['error']) &&  ($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE || $_FILES['file']['error'] == UPLOAD_ERR_FORM_SIZE))
				echo "<span style=\"color:red;\">La taille du fichier dépasse la taille autorisée.</span>";
		

			// Fichier trop gros -> post_max_size -> message d'erreur
			if(empty($_FILES) && empty($_POST) && isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post')
				echo "<span style=\"color:red;\">La taille du fichier dépasse la taille de transfert autorisée.</span>";

			?>
			<form action="" method="post" enctype="multipart/form-data">
			<p>
				BDM - Formulaire d'envoi de fichier multimédia :<br />
				<input type="file" name="file" /><br />
				<input type="submit" value="Envoyer" />

				<br /><br />
				P.-S. :   La taille maximale autorisée est de : <?php echo ini_get('upload_max_filesize'); ?><br />
				P.-S. 2 : Les extensions autorisées sont :
			<?php
				foreach ($ext_allow as $ext)
					echo $ext.' ';
			?>
			</p>
		</form>

		<?php
		}
		?>
	</body>
</html>
