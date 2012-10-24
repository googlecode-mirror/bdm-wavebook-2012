
	<!-- Corps du site -->
    <section id="corps">
		<div class="row">
		  <div class="span8">
			<h2>Changer votre image de profil:</h2>
			<p><strong>Attention:</strong> Vous devez apparaitre clairement sur votre image de profil. Les types de fichiers acceptés sont : <?php echo str_replace("|",", ", Upload::$image_file_extension); ?></p>
			<form action="<?php echo url('account/upload_new_avatar'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<p><input type="file" id="userfile" name="userfile" /></p>
				<p><input type="submit" value="Envoyer" class="btn btn-primary" /> </p>
			</form>
		
		  </div>
		  <div class="span4">
			<h3>Avatar actuel:</h3>
			<img src="<?php echo $list_avatars[0]->getMiniatureLink(); ?>" class="img-polaroid avatar-big" alt="Avatar courant" title="Avatar courant" />
		  </div>
		<div class="span12">
			<hr/>
			<h2>Vos anciennes images de profils :</h2>
			<p>Ces images sont également utilisées par le programme de reconnaissance faciale lors de la phase d'authentification sur le site.</p>
			<table class="table table-striped">
				<tr><th>Aperçu</th><th>Date ajout</th><th>Téléchargement</th></tr>
				<?php
					for($i=1; $i < count($list_avatars); $i++)
					{
						echo '<tr><td><img class="img-polaroid avatar-little" src="'.$list_avatars[$i]->getMiniatureLink().'" alt="Avatar '.$i.'" title="Avatar '.$i.'" /></td><td>'.$list_avatars[$i]->date.'</td><td><a target="_blank" href="'.$list_avatars[$i]->getLink().'">Lien direct</a></td></tr>';
					}
				 ?>
			</table>
		
		</div>
		</div>
    </section>
