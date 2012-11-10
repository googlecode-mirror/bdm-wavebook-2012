
	<!-- Corps du site -->
    <section id="corps">
		<div class="row">
		  <div class="span8">
			  <h1>Flux d'actualités</h1>
			 <?php			
				if(count($files) == 0)
				{
					echo '<div class="alert alert-info"><strong>Oups!</strong> Aucune actualité ...</div>';
				}
				else
				{
					foreach ($files as $file)
					{
						$user = User::getUserById($file->id_user);
						$list_avatars = Avatar::getAvatarsByUserId($file->id_user);
						
						echo '<hr/>';
						echo '<div class="post">
								<a href="'.url('profil/view/'.$file->id_user).'"><img src="'. $list_avatars[0]->getMiniatureLink() . '" class="img-polaroid avatar-little" alt="Voir le profil de ' . ucfirst($user->vorname) . ' ' . ucfirst($user->name). '" title="Voir le profil de ' . ucfirst($user->vorname) . ' ' . ucfirst($user->name). '" /></a>
								<h4>' . ucfirst($user->vorname) . ' ' . ucfirst($user->name). ' a partagé : <small>(le ' . $file->date . ')</small> <span class="label label-important">'.$file->type.'</span></h4>
								<div class="well">
									<blockquote>
									  <p>'.$file->desc.'</p>
									</blockquote>
									'.$file->getHTML().'
									<p><i class="icon-tags"></i> Tags: '.tags($file->keywords).'</p>			
								</div>
						</div>';
					}
				}
			?>
		  </div>
		  <div class="span4">
			<h3>Actions:</h3>
			<div class="dropdown">
			  <button class="dropdown-toggle btn" data-toggle="dropdown" >Dérouler <span class="caret"></span></button>
			  <a href="" class="btn btn-info"><i class="icon-refresh icon-white"></i></a>
			  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><a tabindex="-1" href="<?php echo url('flux/share'); ?>"><i class="icon-upload"></i> Partager</a></li>
				<li><a tabindex="-1" href="<?php echo url('profil'); ?>"><i class="icon-user"></i> Profil</a></li>
				<li class="divider"></li>
				<li><a tabindex="-1" href="<?php echo url('account/logout'); ?>"><i class="icon-off"></i> Déconnexion</a></li>
			  </ul>
			</div>
			</div>
		</div>
    </section>
