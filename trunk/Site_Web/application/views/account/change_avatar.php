
	<!-- Corps du site -->
	<script type="text/javascript">
	$(document).ready(function() {

	//Mode 1 : par formulaire
	$("#form_choose").click(function() {
			 $("#avatar_change_form").attr('action','<?php echo url('account/upload_new_avatar'); ?>');
			 $("#modular").html('<div id="modular"><input type="file" id="userfile" name="userfile" /></div>');
		});

	//Mode 2 : par webcam (prise simple)
	$("#webcam_choose").click(function() 
		{
			 $("#avatar_change_form").attr('action','<?php echo url('account/upload_new_avatar_with_cam'); ?>');
			 $("#modular").html('<div id="status"></div><div><div id="cam"></div><div id="canvas"></div></div><p><button type="button" class="btn btn-info" onClick="webcam.configure()">Configuration...</button> &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info" onClick="webcam.snap()">Capturer maintenant</button><input type="text" name="url_capture" id="url_capture" style="visibility: hidden;" /></p>');
	
		// Configuration de la capture
		webcam.set_api_url('<?php $seed = 'JvKnrQWPsfuhffdfAuH'; $hash = sha1(uniqid($seed . mt_rand(), true)); echo base_url() . './assets/upload.php?uniq_hash=' . substr($hash, 0, 10); ?>');
		webcam.set_quality(100);
		webcam.set_shutter_sound(true, '<?php echo url('assets/docs/shutter.mp3'); ?>');
		webcam.set_swf_url('<?php echo url('assets/docs/webcam.swf'); ?>');
		
		
		// Callbacks
		webcam.set_hook('onComplete', function(response){
			webcam.reset();
			$('#status').html('<div class="alert alert-success">Capture uploadée !<button type="button" class="close" data-dismiss="alert">x</button></div>');
			$('#url_capture').val(response);
			$('#canvas').html('<img src="<?php echo base_url() . '../Base_de_donnees/tmp/'; ?>'+response+'" alt="Votre capture" title="Votre capture" />');
		});
		
		webcam.set_hook('onError', function(response){
			$('#status').html('<div class="alert alert-error">Error: ' + response + '<button type="button" class="close" data-dismiss="alert">x</button></div>');
		});

		// Mise en place de la webcam
		$('#cam').html(webcam.get_html(280,210,640,480));

		});
		
		//Callback pour la soumission du form
		$("#avatar_change_form").submit(function() 
		{
				if($('#url_capture').val() == "")
				{
					$('#status').html('<div class="alert alert-error"><strong>Erreur:</strong> Une capture est attendue !<button type="button" class="close" data-dismiss="alert">x</button></div>');
					return false;
				}
				else
				{
					return true;
				}
		});
	});
    </script>
    <section id="corps">
		<div class="row">
		  <div class="span8">
			<h2>Changer votre image de profil:</h2>
			<p><strong>Attention:</strong> Vous devez apparaitre clairement sur votre image de profil. Les types de fichiers acceptés sont : <?php echo str_replace("|",", ", Upload::$image_file_extension); ?></p>
			<hr/>
			  <div class="btn-group" style="text-align:right;" data-toggle="buttons-radio" style="">
				<button type="button" id="form_choose" class="btn btn-inverse active">Par formulaire</button>
			 	<button type="button" id="webcam_choose" class="btn btn-inverse">Par webcam</button>
			  </div>
			<hr/>
			<form action="<?php echo url('account/upload_new_avatar'); ?>" id="avatar_change_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<div id="modular"><input type="file" id="userfile" name="userfile" /></div>
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
				<tr><th>Aperçu</th><th>Date ajout</th><th>Téléchargement</th><th>Supprimer</th></tr>
				<?php
					for($i=1; $i < count($list_avatars); $i++)
					{
						echo '<tr><td><img class="img-polaroid avatar-little" src="'.$list_avatars[$i]->getMiniatureLink().'" alt="Avatar '.$i.'" title="Avatar '.$i.'" /></td><td>'.$list_avatars[$i]->date.'</td><td><a target="_blank" href="'.$list_avatars[$i]->getLink().'"><i class="icon-file"></i> Lien direct</a></td><td><a href="'. url('account/delete_avatar') .'/'. $list_avatars[$i]->id.'"><i class="icon-trash"></i> Supprimer</td></tr>';
					}
				 ?>
			</table>
		
		</div>
		</div>
    </section>
