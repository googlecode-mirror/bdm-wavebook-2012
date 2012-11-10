
	<!-- Corps du site -->
    <section id="corps">
		<div class="row">
		  <div class="span8">
			  <h2>Partager sur WaveBook</h2>
			  <p><strong>Informations:</strong> Vous pouvez partager uniquement les fichiers de type : <em><?php echo str_replace("|",", ", Upload::$image_file_extension.'|'.Upload::$music_file_extension.'|'.Upload::$video_file_extension.'|'.Upload::$document_file_extension); ?></em>.</p>
			  <hr/>
			  <form class="form-horizontal" action="<?php echo url('flux/share_validation'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<div class="control-group">
					<label class="control-label" for="keywords">Mots-clés</label>
					<div class="controls">
						<input type="text" id="keywords" name="keywords" placeholder="Mots-clés" value="<?php echo set_value('keywords'); ?>" />
					</div>
				   </div>

				     <div class="control-group">
					<label class="control-label" for="description">Description</label>
					<div class="controls">
						<textarea id="description" name="description" placeholder="Description" rows="3" cols="20" ><?php echo set_value('description'); ?></textarea> 
					</div>
				     </div>

				<div class="control-group">
					<label class="control-label" for="file">Fichier multimédia</label>
					<div class="controls">
					  <input type="file" name="userfile" id="file" />
					</div>
				  </div>

				<div class="control-group">
					<div class="controls">
					  <button type="submit" class="btn btn-primary"><i class="icon-upload icon-white"></i> Partager</button>
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
				<li><a tabindex="-1" href="<?php echo url('flux/index'); ?>"><i class="icon-th-list"></i> Voir le flux</a></li>
				<li><a tabindex="-1" href="<?php echo url('profil'); ?>"><i class="icon-user"></i> Profil</a></li>
				<li class="divider"></li>
				<li><a tabindex="-1" href="<?php echo url('account/logout'); ?>"><i class="icon-off"></i> Déconnexion</a></li>
			  </ul>
			</div>
			</div>
		</div>
    </section>
