
	<!-- Corps du site -->
    <section id="corps">
		<div class="row">
		  <div class="span8">
			  <h1>A propos de WaveBook</h1>
			  <h3>Objectifs</h3>
			  <p><span class="label">WaveBook</span> est une plateforme permettant de partager vos fichiers multimédias (musiques, photos, vidéos, documents) avec le monde entier en quelques clics !</p>
			  <p>De plus, le site utilise un protocole d'authentification révolutionnaire : la reconnaissance faciale combinée à la reconnaissance vocale. Essayez dès à présent !</p>
			  <h3>Le contexte</h3>
			  <p>...</p>
			  <h3>L'équipe</h3>
			  <p>...</p>
			  <h3>Technologies utilisées</h3>
			  <p>...</p>
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
				<h3>Pas encore inscrit ?</h3>
				<a href="<?php  echo url('home/register'); ?>" class="btn btn-large btn-primary"><i class="icon-plus-sign icon-white"></i> Inscription rapide</a>
			</div>
		  </div>
		</div>
    </section>
