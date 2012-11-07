
	<!-- Corps du site -->
    <section id="corps">
		<div class="row">
		  <div class="span8">
			  <h1>Inscription sur WaveBook</h1>
			  <p><strong>Information:</strong> Votre mot de passe et votre image de profil seront utilisés par le système d'authentification du site. Merci de choisir un avatar reconnaisable et de type : <em><?php echo str_replace("|",", ",Upload::$image_file_extension); ?></em></p>
			  <hr/>
			  <form class="form-horizontal" action="<?php echo url('home/register_validation'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				   <div class="control-group">
					<label class="control-label" for="name">Votre nom</label>
					<div class="controls">
						<input type="text" id="name" name="name" placeholder="Nom" value="<?php echo set_value('name'); ?>" />
					</div>
				   </div>
				     <div class="control-group">
					<label class="control-label" for="vorname">Votre prénom</label>
					<div class="controls">
						<input type="text" id="vorname" name="vorname" placeholder="Prénom" value="<?php echo set_value('vorname'); ?>" />
					</div>
				   </div>
				  <div class="control-group">
					<label class="control-label" for="email">Votre Email</label>
					<div class="controls">
					  <input type="text" id="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>" />
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="password">Votre mot de passe</label>
					<div class="controls">
					  <input type="password" name="password" id="password" placeholder="Mot de passe" value="<?php echo set_value('password'); ?>" />
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="avatar">Votre image de profil</label>
					<div class="controls">
					  <input type="file" name="userfile" id="avatar" />
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="sexe">Votre sexe</label>
					<div class="controls">
						<input type="radio" name="sexe" id="sexe" value="Homme"  <?php echo set_radio('sexe', 'Homme', TRUE); ?> /> Homme<br/>
						<input type="radio" name="sexe" value="Femme" <?php echo set_radio('sexe', 'Femme');?> /> Femme
					</div>
				   </div>
				   <div class="control-group">
					<div class="controls">
					  <button type="submit" class="btn btn-primary">S'inscrire</button>
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
