
	<!-- Corps du site -->
    <section id="corps">
		<div class="row">
		  <div class="span8">
			  <h1>Introduction à WaveBook.</h1>
			  <p><span class="label">WaveBook</span> est une plateforme permettant de partager vos fichiers multimédias (musiques, photos, vidéos, documents) avec le monde entier en quelques clics !</p>
			  <p>De plus, le site utilise un protocole d'authentification révolutionnaire : la reconnaissance faciale combinée à la reconnaissance vocale. Essayez dès à présent !</p>
			  <h1>C'est parti !</h1>
			  <div class="hero-unit">
				  <p>Munissez-vous, d'une photo et d'un enregistrement vocale de votre mot de passe.</p>
				  <p>
					<a class="btn btn-info btn-large" href="<?php  echo url('home/login'); ?>">
					  Se connecter maintenant
					</a>
				  </p>
			  </div>
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
		  <div class="span4">
			<div style="padding-left:10px;">
				<h3>Statistiques</h3>
				<p>Il y a <span style="font-size:15px;font-weight:bold;"><?php echo User::countUser(); ?></span> utilisateurs qui ont partagés <span style="font-size:15px;"><?php echo File::countFiles(); ?></span> fichiers.</p>
			</div>
		  </div>
		  <div class="span4">
			<div style="padding-left:10px;">
				<h3>Pas encore inscrit ?</h3>
				<a href="<?php  echo url('home/register'); ?>" class="btn btn-large btn-primary"><i class="icon-plus-sign icon-white"></i> Inscription rapide</a>
			</div>
		  </div>
		</div>
    </section>
