	<?php
		$list_avatars = Avatar::getAvatarsByUserId($user->id);
		$list_files = $user->getUserFiles();
	?>

	<!-- Corps du site -->
    <section id="corps">
		<div class="row">
		  <div class="span8">
			<h2>Mur de <?php echo ucfirst($user->vorname) . ' ' . ucfirst($user->name); ?> :</h2>
			<?php
				if(count($list_files) == 0)
				{
					echo '<div class="alert alert-info"><strong>Oups!</strong> Le mur est encore vide...</div>';
				}
				else
				{
					for($i = 0; $i < count($list_files); $i++)
					{
						$f = $list_files[$i];
						if($i > 0)
						echo '<hr/>';
		
						echo '<div class="post">
								<a href="'.url('profil/view/'.$f->id_user).'"><img src="'. $list_avatars[0]->getMiniatureLink() . '" class="img-polaroid avatar-little" alt="Voir le profil de ' . ucfirst($user->vorname) . ' ' . ucfirst($user->name). '" title="Voir le profil de ' . ucfirst($user->vorname) . ' ' . ucfirst($user->name). '" /></a>
								<h4>' . ucfirst($user->vorname) . ' ' . ucfirst($user->name). ' a partagé : <small>(le ' . $f->date . ')</small> <span class="label label-important">'.$f->type.'</span></h4>
								<div class="well">
									<blockquote>
									  <p>'.$f->desc.'</p>
									</blockquote>
									'.$f->getHTML().'
									<p><i class="icon-tags"></i> Tags: '.tags($f->keywords).'</p>			
								</div>
						</div>';
					}
				}			
			?>		
		  </div>
		  <div class="span4">
			<h3>Informations:</h3>
			<img src="<?php echo $list_avatars[0]->getMiniatureLink(); ?>" class="img-polaroid avatar-big" alt="Avatar courant de <?php echo ucfirst($user->vorname) . ' ' . ucfirst($user->name); ?>" title="Avatar courant de <?php echo ucfirst($user->vorname) . ' ' . ucfirst($user->name); ?>" />
			<p></p>
			<p><strong>Nom: </strong><?php echo ucfirst($user->name); ?></p>
			<p><strong>Prénom: </strong><?php echo ucfirst($user->vorname); ?></p>
			<p><strong>Sexe: </strong><?php if ($user->sex == 1) { echo 'Homme'; } else { echo 'Femme'; } ?></p>
			<p><strong>Email: </strong><?php echo ucfirst($user->email); ?></p>
			<p><strong>Inscrit le: </strong><?php echo $user->date; ?></p>
			<p><strong>Nb de partage: </strong><?php echo $user->countUserFiles(); ?></p>
		  </div>
		</div>
    </section>
