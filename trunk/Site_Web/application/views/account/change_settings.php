	<!-- Corps du site -->
    <section id="corps">
		<div class="row">
		  <div class="span8">
			<h2>Informations personnelles</h2>
			<hr />
			<form class="form-horizontal" action="<?php echo url('account/settings_validation'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				   <div class="control-group">
					<label class="control-label" for="name">Votre nom</label>
					<div class="controls">
						<input type="text" id="name" name="name" placeholder="Nom" value="<?php echo $user->name; ?>" />
					</div>
				   </div>
				     <div class="control-group">
					<label class="control-label" for="vorname">Votre prénom</label>
					<div class="controls">
						<input type="text" id="vorname" name="vorname" placeholder="Prénom" value="<?php echo $user->vorname; ?>" />
					</div>
				   </div>
				  <div class="control-group">
					<label class="control-label" for="email">Votre Email</label>
					<div class="controls">
					  <input type="text" id="email" name="email" placeholder="Email" value="<?php echo $user->email; ?>" />
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="password">Votre mot de passe</label>
					<div class="controls">
					  <input type="text" name="password" readonly="readonly" id="password" placeholder="Mot de passe" value="<?php echo $user->password; ?>" />
					  <input style="width: 30px; height:30px;border: 4px;background-color:transparent" id="mic" x-webkit-speech />
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="sexe">Votre sexe</label>
					<div class="controls">
						<input type="radio" name="sexe" id="sexe" value="Homme" <?php if ($user->sex == 1) { echo 'checked="checked"'; } ?> /> Homme<br/>
						<input type="radio" name="sexe" value="Femme"  <?php if ($user->sex == 0) { echo 'checked="checked"'; } ?> /> Femme
					</div>
				   </div>
				   <div class="control-group">
					<div class="controls">
					  <button type="submit" class="btn btn-primary">Modifier</button>
					</div>
				  </div>
				</form>
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
