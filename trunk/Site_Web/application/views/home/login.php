
	<!-- Corps du site -->
    <section id="corps">
		<div class="row">
		  <div class="span8">
			  <h1>Connexion sur WaveBook</h1>
			  <p><strong>Information:</strong> 
			  En attendant, l'équipe de reconnaissance sonore, l'authentification se fait par mot de passe ! Merci de choisir une image de profil, vous correspondant ! Les formats autorisées sont : <em><?php echo str_replace("|",", ",Upload::$image_file_extension); ?></em></p>
			  <hr/>
			  <form class="form-horizontal" action="<?php echo url('home/login_validation'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				  <div class="control-group">
					<label class="control-label" for="avatar">Votre image</label>
					<div class="controls">
					  <input type="file" name="userfile" id="avatar" />
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="password">Votre mot de passe</label>
					<div class="controls">
						<input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" />
					</div>
				   </div>
				   <div class="control-group">
					<div class="controls">
					  <button type="submit" class="btn btn-primary">Se connecter</button>
					</div>
				  </div>
				</form>
		  </div>
		  
		  <div class="span4">
			<div style="padding-left:10px;">
				<h3>Une vaste communautée</h3>
				<p><span class="label">WaveBook</span> compte déjà plusieurs milliers d'utilisateurs ayant partagé des millions de fichiers ! A qui le tour ?</p>
				<p>
					<?php
						for($i = 0; $i < count($ruser); $i++)
						{
								$list_avatars = Avatar::getAvatarsByUserId($ruser[$i]->id);
								echo '<img src="'. $list_avatars[0]->getMiniatureLink().'" class="img-polaroid avatar-little" alt="'.$ruser[$i]->vorname .' '.$ruser[$i]->name . ' est sur Wavebook !" title="'.$ruser[$i]->vorname .' '.$ruser[$i]->name . '  est sur Wavebook !" \> ';
						}
					?>
				</p>
			</div>
		  </div>
		</div>
    </section>
