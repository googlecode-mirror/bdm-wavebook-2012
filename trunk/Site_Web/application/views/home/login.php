
	<!-- Corps du site -->
    <script type="text/javascript">
	$(document).ready(function() {

	//Mode 1 : par formulaire
	$("#form_choose").click(function() {
			 $("#login_form").attr('action','<?php echo url('home/login_validation'); ?>');
			 $("#modular").html('<div id="modular" class="control-group"><label class="control-label" for="avatar">Votre image</label><div class="controls"><input type="file" name="userfile" id="avatar" /></div></div>');
		});

	//Mode 2 : par webcam (prise simple)
	$("#webcam_choose").click(function() 
		{
			 $("#login_form").attr('action','<?php echo url('home/login_validation_with_cam'); ?>');
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
		$("#login_form").submit(function() 
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
			  <h1>Connexion sur WaveBook</h1>
			  <p><strong>Information:</strong> 
			  En attendant, l'équipe de reconnaissance sonore, l'authentification se fait par mot de passe ! Merci de choisir une image de profil, vous correspondant ! Les formats autorisées sont : <em><?php echo str_replace("|",", ",Upload::$image_file_extension); ?></em></p>
			  <hr/>
			  <div class="btn-group" style="text-align:right;" data-toggle="buttons-radio" style="">
				<button type="button" id="form_choose" class="btn btn-inverse active">Par formulaire</button>
			 	<button type="button" id="webcam_choose" class="btn btn-inverse">Par webcam</button>
			  </div>
			  <hr/>
			  <form class="form-horizontal" id="login_form" action="<?php echo url('home/login_validation'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				  <div id="modular" class="control-group">
					<label class="control-label" for="avatar">Votre image</label>
					<div class="controls">
					  <input type="file" name="userfile" id="avatar" />
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="password">Votre mot de passe</label>
					<div class="controls">
						<input type="text" name="password" id="password" value="<?php echo set_value('password'); ?>" />
						<input style="width: 30px; height:30px;border: 4px;background-color:transparent" id="mic" x-webkit-speech />
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
